<?php
include "db.php";

$title = $_POST['title'];
$type = $_POST['type'];
$year = $_POST['year'];
$rating = $_POST['rating'];

if (!empty($title)) {
    $sql = "INSERT INTO media (title, type, year, rating)
            VALUES ('$title', '$type', '$year', '$rating')";
    $conn->query($sql);
}

header("Location: index.php");
?>