<?php
session_start();

if (!isset($_SESSION['role'])) {
    header("Location: rekisteri.php");
    exit();
}

if ($_SESSION['role'] == 'user') {
}
?>

<!DOCTYPE html>
<html lang="fi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kauppa</title>
    <link rel="stylesheet" href="mystyle.css">
</head>
<body>

    <header class="top-bar">
        <a href="etusivu.php"><img src="logo.png" alt="Logo" class="logo"></a>

        <nav class="nav-links">
            <a href="kauppa.php">Kauppa</a>
            <a href="logout.php">Kirjaudu ulos</a>
        </nav>
        <a href="ostoskori.php"><img src="karry.png" alt="Ostoskori" class="karry"></a>
    </header>

    <section class="kuva-teks">
        <h1>Tuoretta kotiruokaa suoraan ovellesi!</h1>
        <p>Tuottajamarket – Kaupunkilaisille vaivatonta kotiruoan hankintaa.</p>

        <nav class="nav-links">
             <a class="shop-btn" href="kauppa.php">Selaa tuotteita</a>
        </nav>
    </section>

    <section class="how">

        <h2>Kuinka Se Toimii</h2>

        <div class="steps">

            <div class="step">
                <h3>1. Rekisteröityminen</h3>
                <p>Luo käyttäjätili helposti.</p>
            </div>

            <div class="step">
                <h3>2. Selaa tuotteita</h3>
                <p>Tutustu paikallisiin tuotteisiin.</p>
            </div>

            <div class="step">
                <h3>3. Lisää ostoskoriin</h3>
                <p>Valitse haluamasi tuotteet.</p>
            </div>

            <div class="step">
                <h3>4. Tarkista ostokset</h3>
                <p>Muokkaa tarvittaessa.</p>
            </div>

            <div class="step">
                <h3>5. Tilauksen vahvistus</h3>
                <p>Vahvista tilauksesi.</p>
            </div>

            <div class="step">
                <h3>6. Toimitus kotiovelle</h3>
                <p>Tuoreet tuotteet suoraan kotiin.</p>
            </div>

            <div class="step">
                <h3>7. Nauti lähiruoasta</h3>
                <p>Helppoa ja vastuullista.</p>
            </div>
        </div>
    </section>

    <footer>© <?= date("Y") ?>Niklas Jurvelin – Omnia</footer>

</body>
</html>



