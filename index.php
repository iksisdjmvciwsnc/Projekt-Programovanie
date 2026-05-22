<?php
// Pripojíme sa k databáze
include "db.php";
?>

<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <title>Evidencia filmov a kníh</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; line-height: 1.6; }
        .nav { background: #f4f4f4; padding: 10px; margin-bottom: 20px; border-radius: 5px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 10px; text-align: left; }
        th { background: #eee; }
        .btn { text-decoration: none; padding: 5px 10px; background: #007bff; color: white; border-radius: 3px; }
        .btn-danger { background: #dc3545; }
    </style>
</head>
<body>

    <div class="nav">
        <strong>Menu:</strong>
        <b>Zoznam médií</b> | 
        <a href="users.php">Správa používateľov</a>
    </div>

    <h2>Zoznam filmov a kníh</h2>
    
    <a href="create.php" class="btn">Pridať nový záznam</a>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Názov</th>
                <th>Typ</th>
                <th>Rok vydania</th>
                <th>Hodnotenie</th>
                <th>Akcie</th> </tr>
        </thead>
        <tbody>
            <?php
            // 1. Vytiahneme všetky dáta z tabuľky 'media'
            $result = $conn->query("SELECT * FROM media");

            // 2. Skontrolujeme, či databáza vrátila aspoň jeden riadok
            if ($result->num_rows > 0) {
                
                // 3. Kým máme nejaké riadky, budeme ich po jednom čítať a vypisovať do tabuľky
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . $row['title'] . "</td>";
                    echo "<td>" . $row['type'] . "</td>";
                    echo "<td>" . $row['year'] . "</td>";
                    echo "<td>" . $row['rating'] . "</td>";
                    
                    // 4. Tu vytvárame odkazy na úpravu a mazanie. Všimni si časť ?id=...
                    echo "<td>
                            <a href='update.php?id=" . $row['id'] . "'>Upraviť</a> | 
                            <a href='delete.php?id=" . $row['id'] . "' style='color: red;'>Vymazať</a>
                          </td>";
                    echo "</tr>";
                }
            } else {
                // Ak je tabuľka v databáze prázdna, vypíšeme túto správu
                echo "<tr><td colspan='6'>Zatiaľ tu nie sú žiadne filmy ani knihy.</td></tr>";
            }
            ?>
        </tbody>
    </table>

</body>
</html>