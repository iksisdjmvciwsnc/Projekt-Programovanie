<?php
$conn = new mysqli("localhost", "root", "", "film_app");

if ($conn->connect_error) {
    die("Chyba pripojenia: " . $conn->connect_error);
}
?>