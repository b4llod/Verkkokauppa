<?php
// Yhdistetään tietokantaan
include "yhteys.php";

$ilmoitus = "";

// Käsitellään rekisteröintilomake vain kun se on lähetetty
if (isset($_POST["rekisteroidy"])) {

    // Luetaan ja siivotaan syötteet
    $sposti  = trim($_POST['e_mail']);
    $ktunnus = trim($_POST['user_name']);
    $salasana = trim($_POST['password']);

    if (empty($ktunnus)) {
        $ilmoitus = "Käyttäjätunnus ei voi olla tyhjä";
    } else {

        // Tarkistetaan onko käyttäjätunnus jo olemassa
        $haku = $yhteys->prepare("SELECT user_id FROM users WHERE user_name = ?");
        $haku->bind_param("s", $ktunnus);
        $haku->execute();
        $haku->store_result();

        if ($haku->num_rows > 0) {
            $ilmoitus = "Käyttäjätunnus on jo käytössä!";
        } else {
            // Hashataan salasana ja tallennetaan uusi käyttäjä tietokantaan
            $hashedPassword = password_hash($salasana, PASSWORD_DEFAULT);

            $haku = $yhteys->prepare("INSERT INTO users (e_mail, user_name, password, role) VALUES (?, ?, ?, 'user')");
            $haku->bind_param("sss", $sposti, $ktunnus, $hashedPassword);

            if ($haku->execute()) {
                $ilmoitus = "Rekisteröinti onnistui!";
            } else {
                $ilmoitus = "Virhe rekisteröinnissä";
            }
        }

        $haku->close();
    }
}
?>
<!DOCTYPE html>
<html lang="fi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="FAVICON.png">
    <title>Rekisteröinti</title>
    <link rel="stylesheet" href="mystyle.css">
</head>
<body>

    <!-- Yläpalkki: logo ja linkki kirjautumiseen -->
    <header class="top-bar">
        <img src="logo.png" alt="Logo" class="logo">
        <nav class="nav-links">
            <a href="login.php">Kirjaudu sisään</a>
        </nav>
    </header>

    <main>
        <!-- Rekisteröintilomake ilmoituksineen -->
        <section class="form-section">
            <h2>Rekisteröidy</h2>

            <!-- Näytetään palaute rekisteröinnin onnistumisesta tai virheestä -->
            <?php if ($ilmoitus != ""): ?>
                <p style="color:black; font-weight:600;">
                    <?= htmlspecialchars($ilmoitus) ?>
                </p>
            <?php endif; ?>

            <form method="post" action="">
                <input type="email" name="e_mail" placeholder="Sähköposti" required>
                <input type="text" name="user_name" placeholder="Käyttäjätunnus" required>
                <input type="password" name="password" placeholder="Salasana" required>
                <button type="submit" name="rekisteroidy">Rekisteröidy</button>
            </form>
        </section>
    </main>

    <!-- Alatunniste: vuosi generoidaan automaattisesti -->
    <footer>© <?= date("Y") ?> Niklas Jurvelin – Omnia</footer>

</body>
</html>