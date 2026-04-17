<?php
session_start();
require_once "yhteys.php";

$session = session_id();

/* Tuotteen lisäys ostsokoriin */

if (isset($_GET["add"])) {

    $product_id = intval($_GET["add"]);

    $cartResult = $yhteys->query("SELECT * FROM cart WHERE session='$session'");
    $cart = $cartResult->fetch_assoc();

    if (!$cart) {

        $yhteys->query("
            INSERT INTO cart (session, order_id)
            VALUES ('$session', 0)
        ");

        $cart_id = $yhteys->insert_id;

    } else {
        $cart_id = $cart["id"];
    }

    $check = $yhteys->query("
        SELECT * FROM cart_item 
        WHERE cart_id=$cart_id 
        AND product_id=$product_id
    ");

    if ($check->num_rows > 0) {

        $yhteys->query("
            UPDATE cart_item 
            SET amount = amount + 1
            WHERE cart_id=$cart_id 
            AND product_id=$product_id
        ");

    } else {

        $yhteys->query("
            INSERT INTO cart_item (cart_id, product_id, amount)
            VALUES ($cart_id, $product_id, 1)
        ");
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

        $yhteys->query("
            DELETE FROM cart_item 
            WHERE cart_id=$cart_id 
            AND product_id=$product_id
        ");
    }

    header("Location: ostoskori.php");
    exit;
}

/* Ostoskorin haku */

$cartResult = $yhteys->query("SELECT * FROM cart WHERE session='$session'");
$cart = $cartResult->fetch_assoc();

$items = null;
$cart_id = $cart["id"] ?? null;

if ($cart_id) {

    $items = $yhteys->query("
        SELECT cart_item.*, products.name, products.prize, products.unit
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

    $yhteys->query("
        INSERT INTO orders (session, name, email, phone, datetime)
        VALUES ('$session', '$name', '$email', '$phone', NOW())
    ");

    $order_id = $yhteys->insert_id;

    $yhteys->query("
        UPDATE cart 
        SET order_id=$order_id 
        WHERE id=$cart_id
    ");

    echo "<h2>Kiitos tilauksesta!</h2>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="fi">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Ostoskori</title>
<link rel="stylesheet" href="mystyle.css">
</head>
<body>

    <header class="top-bar">
        <a href="etusivu.php"><img src="logo.png" alt="Logo" class="logo"></a>

        <nav class="nav-links">
            <a href="kauppa.php">Kauppa</a>
        </nav>
        <a href="ostoskori.php"><img src="karry.png" alt="Ostoskori" class="karry"></a>
    </header>

    <h1>Ostoskori</h1>

    <?php if (!$items || $items->num_rows == 0): ?>

    <p>Ostoskori on tyhjä.</p>
    <a href="kauppa.php">Takaisin kauppaan</a>

    <?php else: ?>

    <table border="1" cellpadding="8">
    <tr>
        <th>Tuote</th>
        <th>Määrä</th>
        <th>Hinta</th>
        <th>Poista</th>
    </tr>

    <?php
    $total = 0;

    while ($i = $items->fetch_assoc()):
        $sum = $i["amount"] * $i["prize"];
        $total += $sum;
    ?>

    <tr>
        <td><?= htmlspecialchars($i["name"]) ?></td>
        <td><?= $i["amount"] ?></td>
        <td><?= number_format($sum, 2) ?> €</td>
        <td>
            <a class="add" href="ostoskori.php?remove=<?= $i["product_id"] ?>">Posita</a>
        </td>
    </tr>

    <?php endwhile; ?>

    </table>

    <h3>Yhteensä: <?= number_format($total, 2) ?> €</h3>

    <h2>Tee tilaus</h2>

    <form method="post">
    <input type="text" name="name" placeholder="Nimi" required><br>
    <input type="email" name="email" placeholder="Sähköposti" required><br>
    <input type="text" name="phone" placeholder="Puhelin" required><br>

    <button type="submit" name="order">Tee tilaus</button>
    </form>

    <?php endif; ?>

</body>
</html>