<?php
session_start();
include "yhteys.php";

$ilmoitus = "";

// Lomakkeen käsittely
if (isset($_POST["kirjaudu"])) {

    $ktunnus = $_POST["user_name"];
    $salasana = $_POST["password"];

    // Haetaan käyttäjät tietokannasta
    $sql = "SELECT * FROM users WHERE user_name = ?";
    $stmt = $yhteys->prepare($sql);
    $stmt->bind_param("s", $ktunnus);
    $stmt->execute();
    $tulos = $stmt->get_result();

    if ($tulos->num_rows == 1) {
        $kayttaja = $tulos->fetch_assoc();

        // Tarkistetaan salasana hash:in avulla
        if (password_verify($salasana, $kayttaja["password"])) {
            $_SESSION["role"] = $kayttaja["role"];
            $_SESSION["user_id"] = $kayttaja["user_id"];

            // Uudelleen ohjataan etusivulle
            header("Location: etusivu.php");
            exit;
        }
        else {
            $ilmoitus = "Väärä salasana";
        }
    } 
    else {
        $ilmoitus = "Käyttäjätunnusta ei löydy";
    }
}
?>

<!DOCTYPE html>
<html lang="fi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="logoTitle.png">
    <title>Kirjaudu sisään</title>
    <link rel="stylesheet" href="mystyle.css">
</head>
<body>

    <header class="top-bar">
        <img src="logo.png" alt="Logo" class="logo">

        <nav class="nav-links">
            <a href="rekisteri.php">Rekisteröidy</a>
        </nav>
    </header>

    <main>
        <section class="form-section">
            <h2>Kirjaudu sisään</h2>

            <?php if ($ilmoitus != ""): ?>
                <p style="color:white; font-weight:600;">
                    <?= htmlspecialchars($ilmoitus) ?>
                </p>
            <?php endif; ?>

            <form method="post" action="">
                <input type="text" name="user_name" placeholder="Käyttäjätunnus" required>
                <input type="password" name="password" placeholder="Salasana" required>
                <button type="submit" name="kirjaudu">Kirjaudu</button>
                <p>Etkö ole rekisteröitynyt vielä? <a href="rekisteri.php">Paina tästä.</a></p>
            </form>
        </section>
    </main>

    <footer>© <?= date("Y") ?> Niklas Jurvelin – Omnia</footer>

</body>
</html>