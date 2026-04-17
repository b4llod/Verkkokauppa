<?php
$yhteys = new mysqli("localhost", "root", "", "vkauppa");

if ($yhteys->connect_error) {
    die("Tietokantayhteys epäonnistui: " . $yhteys->connect_error);
}

$yhteys->set_charset("utf8");
?>