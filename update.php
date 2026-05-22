<?php
include "db.php";

// 1. OPRAVA: Skontrolujeme, či sme vôbec dostali ID. Ak nie, vrátime sa na hlavnú stránku.
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: index.php");
    exit;
}

// 2. OPRAVA: Ochrana ID pred útokmi
$id = $conn->real_escape_string($_GET['id']);

// Spracovanie odoslaného formulára
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 3. OPRAVA: Ochrana pred apostrofmi a prázdnymi číslami (ako v create.php)
    $title = $conn->real_escape_string($_POST['title'] ?? '');
    $type = $conn->real_escape_string($_POST['type'] ?? 'film');
    $year = !empty($_POST['year']) ? $_POST['year'] : 0;
    $rating = !empty($_POST['rating']) ? $_POST['rating'] : 0;

    if (!empty($title)) {
        $conn->query("UPDATE media SET 
            title='$title',
            type='$type',
            year='$year',
            rating='$rating'
            WHERE id='$id'");

        // 4. OPRAVA: Pridaný exit po presmerovaní
        header("Location: index.php");
        exit;
    }
}

// Vytiahnutie dát z databázy pre zobrazenie vo formulári
$result = $conn->query("SELECT * FROM media WHERE id='$id'");

// Ak by niekto do URL zadal ID, ktoré v databáze neexistuje (napr. id=9999), vyhodíme ho preč
if ($result->num_rows == 0) {
    header("Location: index.php");
    exit;
}

$row = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <title>Upraviť záznam</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; line-height: 1.6; }
        .form-group { margin-bottom: 15px; }
    </style>
</head>
<body>
    <h2>Upraviť záznam</h2>
    
    <form method="POST">
        <div class="form-group">
            <label>Názov:</label><br>
            <input type="text" name="title" value="<?php echo htmlspecialchars($row['title']); ?>" required>
        </div>

        <div class="form-group">
            <label>Typ:</label><br>
            <select name="type">
                <option value="film" <?php if($row['type']=="film") echo "selected"; ?>>Film</option>
                <option value="kniha" <?php if($row['type']=="kniha") echo "selected"; ?>>Kniha</option>
            </select>
        </div>

        <div class="form-group">
            <label>Rok vydania:</label><br>
            <input type="number" name="year" value="<?php echo $row['year']; ?>">
        </div>

        <div class="form-group">
            <label>Hodnotenie:</label><br>
            <input type="number" name="rating" value="<?php echo $row['rating']; ?>">
        </div>

        <button type="submit">Uložiť zmeny</button>
        <a href="index.php" style="margin-left: 10px;">Zrušiť</a>
    </form>
</body>
</html>