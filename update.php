<?php
// 1. Pripojenie k databáze (využije tvoj súbor db.php)
include 'db.php';

// 2. Skontrolujeme, či máme ID filmu v URL adrese (napr. update.php?id=1)
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    // Načítame aktuálne dáta tohto filmu z databázy z tabuľky media
    $query = "SELECT * FROM media WHERE id = $id";
    $result = mysqli_query($conn, $query);
    
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
    } else {
        die("Film sa v databáze nenašiel.");
    }
} else {
    die("Chýba ID filmu. Prejdi na index.php a klikni na 'Upraviť'.");
}

// 3. Spracovanie formulára po kliknutí na tlačidlo "Uložiť zmeny"
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $type = mysqli_real_escape_string($conn, $_POST['type']);
    $duration_pages = intval($_POST['duration_pages']);
    $year = intval($_POST['year']);
    $rating = floatval($_POST['rating']);

    // SQL príkaz na úpravu dát
    $update_query = "UPDATE media SET 
        title = '$title', 
        type = '$type', 
        duration_pages = $duration_pages, 
        year = $year, 
        rating = $rating 
        WHERE id = $id";

    if (mysqli_query($conn, $update_query)) {
        // Po úspešnom uložení ťa automaticky hodí späť na hlavnú stránku
        header("Location: index.php");
        exit();
    } else {
        echo "Chyba pri ukladaní: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <title>Upraviť film alebo knihu</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="menu-nav">
        <a href="index.php">Zoznam médií</a>
        <a href="users.php">Správa používateľov</a>
    </div>

    <h2>Upraviť film alebo knihu</h2>

    <form action="" method="POST">
        
        <div class="form-group">
            <label>Názov:</label>
            <input type="text" name="title" value="<?php echo htmlspecialchars($row['title']); ?>" required>
        </div>

        <div class="form-group">
            <label>Typ:</label>
            <select name="type">
                <option value="film" <?php if($row['type'] == 'film') echo 'selected'; ?>>Film</option>
                <option value="kniha" <?php if($row['type'] == 'kniha') echo 'selected'; ?>>Kniha</option>
            </select>
        </div>

        <div class="form-group">
            <label>Rozsah / Dĺžka:</label>
            <input type="number" name="duration_pages" value="<?php echo intval($row['duration_pages']); ?>" required>
        </div>

        <div class="form-group">
            <label>Rok vydania:</label>
            <input type="number" name="year" value="<?php echo intval($row['year']); ?>" required>
        </div>

        <div class="form-group">
            <label>Hodnotenie (0.0 - 10.0):</label>
            <input type="number" name="rating" step="0.1" min="0" max="10" value="<?php echo floatval($row['rating']); ?>" required>
        </div>

        <button type="submit">Uložiť zmeny</button>
        
        <a href="index.php" class="back-link">Späť na zoznam</a>
    </form>

</body>
</html>