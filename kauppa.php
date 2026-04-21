<?php
session_start();
require_once "yhteys.php";

$categories = $yhteys->query("SELECT * FROM categories");

$search = $_GET["search"] ?? "";
$selectedCats = $_GET["cat"] ?? [];

$sql = "SELECT products.*, categories.name AS category
        FROM products
        JOIN categories ON products.category_id = categories.id
        WHERE 1";

if (!empty($search)) {
    $sql .= " AND products.name LIKE '%$search%'";
}

if (!empty($selectedCats)){
    $ids = implode(",", array_map('intval', $selectedCats));
    $sql .= " AND products.category_id IN ($ids)";
}

$products = $yhteys->query($sql);
?>
<!DOCTYPE html>
<html lang="fi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="logoTitle.png">
    <title>Kauppa</title>
    <link rel="stylesheet" href="mystyle.css">
</head>
<body>

    <header class="top-bar">
        <a href="etusivu.php"><img src="logo.png" alt="Logo" class="logo"></a>

        <nav class="nav-links">
            <a href="etusivu.php">Etusivu</a>
            <a href="logout.php">Kirjaudu ulos</a>
        </nav>
        <a href="ostoskori.php"><img src="karry.png" alt="Ostoskori" class="karry"></a>
    </header>

    <div class="container">

        <form method="get" class="filters">
            <input type="text" name="search" placeholder="Hae tuotteita..." value="<?= htmlspecialchars($search) ?>">

            <div class="cat-box">
                <?php while($c = $categories->fetch_assoc()): ?>
                <label>
                    <input type="checkbox" name="cat[]" value="<?= $c['id'] ?>"
                    <?= in_array($c['id'],$selectedCats) ? "checked" : "" ?>>
                    <?= $c['name'] ?>
                </label>
                <?php endwhile; ?>
            </div>
            
            <button>Suodata</button>
        </form>

        <div class="products">
            <?php while($p = $products->fetch_assoc()): ?>
            <div class="product">
                <h3><?= $p['name'] ?></h3>

                <p><strong><?= $p['category']?></strong></p>
                <p><?= $p['description'] ?></p>
                <p class="price"><?= $p['prize'] ?> € / <?= $p['unit'] ?></p>

                <a class="add" href="ostoskori.php?add=<?= $p['id'] ?>">Lisää ostoskoriin</a>
            </div>
        <?php endwhile; ?>
        </div>
    </div>

    <footer>© <?= date("Y") ?> Niklas Jurvelin – Omnia</footer>

</body>
</html>