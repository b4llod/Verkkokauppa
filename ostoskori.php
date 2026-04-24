<?php
session_start();
require_once "yhteys.php";

$session = session_id();

/* Tuotteen lisäys ostoskoriin */
if (isset($_GET["add"])) {

    $product_id = intval($_GET["add"]);

    $cartResult = $yhteys->query("SELECT * FROM cart WHERE session='$session'");
    $cart = $cartResult->fetch_assoc();

    if (!$cart) {
        $yhteys->query("INSERT INTO cart (session, order_id) VALUES ('$session', 0)");
        $cart_id = $yhteys->insert_id;
    } else {
        $cart_id = $cart["id"];
    }

    $check = $yhteys->query("SELECT * FROM cart_item WHERE cart_id=$cart_id AND product_id=$product_id");

    if ($check->num_rows > 0) {
        $yhteys->query("UPDATE cart_item SET amount = amount + 1 WHERE cart_id=$cart_id AND product_id=$product_id");
    } else {
        $yhteys->query("INSERT INTO cart_item (cart_id, product_id, amount) VALUES ($cart_id, $product_id, 1)");
    }

    header("Location: ostoskori.php");
    exit;
}

/* Tuotteen poisto ostoskorista */
if (isset($_GET["remove"])) {

    $product_id = intval($_GET["remove"]);

    $cartResult = $yhteys->query("SELECT * FROM cart WHERE session='$session'");
    $cart = $cartResult->fetch_assoc();

    if ($cart) {
        $cart_id = $cart["id"];
        $yhteys->query("DELETE FROM cart_item WHERE cart_id=$cart_id AND product_id=$product_id");
    }

    header("Location: ostoskori.php");
    exit;
}

/* Määrän muutos */
if (isset($_GET["qty"]) && isset($_GET["pid"])) {

    $product_id = intval($_GET["pid"]);
    $change = intval($_GET["qty"]);

    $cartResult = $yhteys->query("SELECT * FROM cart WHERE session='$session'");
    $cart = $cartResult->fetch_assoc();

    if ($cart) {
        $cart_id = $cart["id"];

        $row = $yhteys->query("
            SELECT cart_item.amount, products.stock 
            FROM cart_item 
            JOIN products ON cart_item.product_id = products.id
            WHERE cart_item.cart_id=$cart_id AND cart_item.product_id=$product_id
        ")->fetch_assoc();

        if ($row) {
            $new_amount = $row["amount"] + $change;

            if ($new_amount < 1) {
                $yhteys->query("DELETE FROM cart_item WHERE cart_id=$cart_id AND product_id=$product_id");
            } elseif ($new_amount <= $row["stock"]) {
                $yhteys->query("UPDATE cart_item SET amount=$new_amount WHERE cart_id=$cart_id AND product_id=$product_id");
            }
        }
    }

    header("Location: ostoskori.php");
    exit;
}

/* Ostoskorin haku */
$cartResult = $yhteys->query("SELECT * FROM cart WHERE session='$session'");
$cart = $cartResult->fetch_assoc();

$items = null;
$cart_id = $cart["id"] ?? null;
$order_success = false;

if ($cart_id) {
    $items = $yhteys->query("
        SELECT cart_item.*, products.name, products.prize, products.unit, products.stock
        FROM cart_item
        JOIN products ON cart_item.product_id = products.id
        WHERE cart_item.cart_id=$cart_id
    ");
}

/* Tilauksen tallennus */
if (isset($_POST["order"]) && $cart_id) {

    $name  = $yhteys->real_escape_string($_POST["name"]);
    $email = $yhteys->real_escape_string($_POST["email"]);
    $phone = $yhteys->real_escape_string($_POST["phone"]);

    $yhteys->query("INSERT INTO orders (session, name, email, phone, datetime) VALUES ('$session', '$name', '$email', '$phone', NOW())");

    $order_id = $yhteys->insert_id;

    $yhteys->query("UPDATE cart SET order_id=$order_id WHERE id=$cart_id");
    $yhteys->query("DELETE FROM cart WHERE session='$session'");
    
    $order_success = true;
}
?>

<!DOCTYPE html>
<html lang="fi">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="icon" type="image/png" href="FAVICON.png">
<title>Ostoskori</title>
<link rel="stylesheet" href="mystyle.css">
</head>
<body>

    <header class="top-bar">
        <a href="etusivu.php"><img src="logo.png" alt="Logo" class="logo"></a>
        <nav class="nav-links">
            <a href="kauppa.php">Kauppa</a>
        </nav>
    </header>
    
    <main class="ostoskori-main">

    <?php if ($order_success): ?>
        <div class="order-success">
            <h1>Kiitos tilauksestasi!</h1>
            <p>Hei <strong><?= htmlspecialchars($name) ?></strong>, toivottavasti asioit meillä vielä!</p>
            <button class="takauppa"><a href="kauppa.php">Jatka ostoksia</a></button>
        </div>

    <?php elseif (!$items || $items->num_rows == 0): ?>
        <h1>Ostoskori</h1>
        <p>Ostoskori on tyhjä.</p>
        <button class="takauppa"><a href="kauppa.php">Takaisin kauppaan</a></button>

    <?php else: ?>

        <div class="ostoskori-row">
            <div class="korin-info">
        
                <h1>Ostoskori</h1>

                <div class="cart-items">
                <?php
                $total = 0;
                while ($i = $items->fetch_assoc()):
                    $sum = $i["amount"] * $i["prize"];
                    $total += $sum;
                ?>
                <div class="cart-item">
                    <a class="add" href="ostoskori.php?remove=<?= $i["product_id"] ?>">Poista</a>
                    <span class="item-name"><?= htmlspecialchars($i["name"]) ?></span>
                    <a href="ostoskori.php?qty=-1&pid=<?= $i["product_id"] ?>" class="qty-btn">−</a>
                    <span class="item-amount"><?= $i["amount"] ?></span>
                    <a href="ostoskori.php?qty=+1&pid=<?= $i["product_id"] ?>" class="qty-btn">+</a>
                    <span class="item-price"><?= number_format($sum, 2) ?> €</span>
                </div>
                <?php endwhile; ?>
                </div>

                <div class="cart-footer">
                    <a class="takauppa" href="kauppa.php">&laquo; Takaisin kauppaan</a>
                    <span>Yhteensä <strong><?= number_format($total, 2) ?> €</strong></span>
                </div>

            </div>

            <div class="tilaus-info">
                <h2>Tee tilaus</h2>
                <form method="post">
                    <input type="text" name="name" placeholder="Nimi" required><br>
                    <input type="email" name="email" placeholder="Sähköposti" required><br>
                    <input type="text" name="phone" placeholder="Puhelin" required><br>
                    <button class="takauppa" type="submit" name="order">Tee tilaus</button>
                </form>
            </div>
        </div>

    <?php endif; ?>

    </main>
</body>
</html>