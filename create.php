<?php
include "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 1. Ošetrenie prázdnych hodnôt (používame operátor ?? pre PHP 8)
    $title = $_POST['title'] ?? '';
    $type = $_POST['type'] ?? 'film';
    
    // Ak rok alebo hodnotenie ostanú prázdne, nastavíme im predvolenú hodnotu 0, 
    // aby databáza neprotestovala, že do čísla vkladáme prázdny text.
    $year = !empty($_POST['year']) ? $_POST['year'] : 0;
    $rating = !empty($_POST['rating']) ? $_POST['rating'] : 0;

    if (!empty($title)) {
        // 2. Ochrana pred apostrofmi (tzv. Escapovanie)
        // Toto zabráni tomu, aby názvy ako "Assassin's Creed" rozbili databázu
        $title_escaped = $conn->real_escape_string($title);
        $type_escaped = $conn->real_escape_string($type);

        // 3. Bezpečné vloženie do databázy
        $sql = "INSERT INTO media (title, type, year, rating)
                VALUES ('$title_escaped', '$type_escaped', '$year', '$rating')";
        
        $conn->query($sql);
        
        header("Location: index.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <title>Pridať záznam</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; line-height: 1.6; }
        .form-group { margin-bottom: 15px; }
    </style>
</head>
<body>
    <h2>Pridať nový film alebo knihu</h2>
    
    <form method="POST" action="">
        <div class="form-group">
            <label>Názov:</label><br>
            <input type="text" name="title" required>
        </div>

        <div class="form-group">
            <label>Typ:</label><br>
            <select name="type">
                <option value="film">Film</option>
                <option value="kniha">Kniha</option>
            </select>
        </div>

        <div class="form-group">
            <label>Rok vydania:</label><br>
            <input type="number" name="year">
        </div>

        <div class="form-group">
            <label>Hodnotenie (napr. 1-10):</label><br>
            <input type="number" name="rating">
        </div>

        <button type="submit">Pridať do databázy</button>
    </form>
    
    <br>
    <a href="index.php">Späť na zoznam</a>
</body>
</html>