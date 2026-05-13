<?php
$conn = new mysqli("localhost", "root", "", "film_app"); // Opravený názov na film_app

if ($conn->connect_error) {
    die("Chyba: " . $conn->connect_error);
}
?>