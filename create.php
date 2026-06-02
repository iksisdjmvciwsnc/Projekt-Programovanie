<?php
include "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 1. Ošetrenie textových hodnôt
    $title = $_POST['title'] ?? '';
    $type = $_POST['type'] ?? 'film';
    
    // Rok zostáva ako celé číslo
    $year = !empty($_POST['year']) ? intval($_POST['year']) : 0;
    
    // NOVÉ: Hodnotenie spracujeme ako desatinné číslo pomocou floatval()
    $rating = !empty($_POST['rating']) ? floatval($_POST['rating']) : 0.0;
    
    // NOVÉ: Načítanie dĺžky (minúty alebo strany)
    $duration_pages = !empty($_POST['duration_pages']) ? intval($_POST['duration_pages']) : 0;

    if (!empty($title)) {
        // 2. Escapovanie kvôli bezpečnosti
        $title_escaped = $conn->real_escape_string($title);
        $type_escaped = $conn->real_escape_string($type);

        // 3. Bezpečné vloženie s novým stĺpcom duration_pages
        $sql = "INSERT INTO media (title, type, year, rating, duration_pages)
                VALUES ('$title_escaped', '$type_escaped', '$year', '$rating', '$duration_pages')";
        
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
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Pridať nový film alebo knihu</h2>
    
    <form method="POST" action="">
        <div class="form-group">
            <label>Názov:</label>
            <input type="text" name="title" required>
        </div>

        <div class="form-group">
            <label>Typ:</label>
            <select name="type" id="media-type" onchange="obnovPolickoDlzky()">
                <option value="film">Film</option>
                <option value="kniha">Kniha</option>
            </select>
        </div>

        <div class="form-group">
            <label id="dlzka-label">Dĺžka filmu (v minútach):</label>
            <input type="number" name="duration_pages" min="0">
        </div>

        <div class="form-group">
            <label>Rok vydania:</label>
            <input type="number" name="year">
        </div>

        <div class="form-group">
            <label>Hodnotenie (napr. 0.0 - 10.0):</label>
            <input type="number" name="rating" min="0" max="10" step="0.1">
        </div>

        <button type="submit">Pridať do databázy</button>
    </form>
    
    <br>
    <a href="index.php" class="back-link">Späť na zoznam</a>

    <script>
    function obnovPolickoDlzky() {
        var selectType = document.getElementById("media-type").value;
        var label = document.getElementById("dlzka-label");
        
        if (selectType === "kniha") {
            label.innerText = "Počet strán knihy:";
        } else {
            label.innerText = "Dĺžka filmu (v minútach):";
        }
    }
    </script>
</body>
</html>