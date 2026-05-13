<?php include "db.php"; ?>
<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <title>Moja Filmová Databáza</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; line-height: 1.6; }
        .nav { background: #f4f4f4; padding: 10px; margin-bottom: 20px; border-radius: 5px; }
        form { background: #e9e9e9; padding: 15px; border-radius: 5px; }
        input, select { margin: 5px 0; padding: 5px; }
        .item { border-bottom: 1px solid #ccc; padding: 10px 0; }
    </style>
</head>
<body>

    <div class="nav">
        <strong>Menu:</strong> 
        <a href="index.php">Filmy a Knihy</a> | 
        <a href="users.php" style="color: blue; font-weight: bold;">Spravovať používateľov</a>
    </div>

    <h2>Pridať nové médium</h2>
    <form action="create.php" method="POST">
        <input type="text" name="title" placeholder="Názov" required>
        <select name="type">
            <option value="film">Film</option>
            <option value="kniha">Kniha</option>
        </select>
        <input type="number" name="year" placeholder="Rok vydania">
        <input type="number" name="rating" placeholder="Hodnotenie (1-10)">
        <button type="submit">Pridať do zoznamu</button>
    </form>

    <hr>

    <h2>Zoznam médií</h2>
    <?php
    $result = $conn->query("SELECT * FROM media");

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div class='item'>";
            echo "<b>" . $row['title'] . "</b> (" . $row['type'] . ") - " . $row['year'] . " | ⭐ " . $row['rating'];
            echo " <br> <a href='update.php?id=" . $row['id'] . "'>Upraviť</a> | ";
            echo "<a href='delete.php?id=" . $row['id'] . "' onclick='return confirm(\"Naozaj zmazať?\")' style='color:red;'>Zmazať</a>";
            echo "</div>";
        }
    } else {
        echo "Žiadne záznamy sa nenašli.";
    }
    ?>

</body>
</html>