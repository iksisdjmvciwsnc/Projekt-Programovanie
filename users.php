<?php include "db.php"; ?>
<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <title>Správa používateľov</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; line-height: 1.6; }
        .nav { background: #f4f4f4; padding: 10px; margin-bottom: 20px; border-radius: 5px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ccc; padding: 10px; text-align: left; }
        th { background: #eee; }
    </style>
</head>
<body>

    <div class="nav">
        <strong>Menu:</strong> 
        <a href="index.php">Späť na Filmy</a> | 
        <b>Zoznam používateľov</b>
    </div>

    <h2>Registrovaní používatelia</h2>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Používateľské meno</th>
                <th>E-mail</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $result = $conn->query("SELECT * FROM users");

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . $row['username'] . "</td>";
                    echo "<td>" . $row['email'] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='3'>Žiadni používatelia v databáze.</td></tr>";
            }
            ?>
        </tbody>
    </table>

</body>
</html>