<?php
include 'db.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    $query = "SELECT * FROM media WHERE id = $id";
    $result = mysqli_query($conn, $query);
    
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
    } else {
        die("Záznam sa v databáze nenašiel.");
    }
} else {
    die("Chýba ID. Prejdi na index.php a klikni na 'Upraviť'.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $type = mysqli_real_escape_string($conn, $_POST['type']);
    $duration_pages = intval($_POST['duration_pages']);
    $year = intval($_POST['year']);
    $rating = floatval($_POST['rating']);

    $update_query = "UPDATE media SET 
        title = '$title', 
        type = '$type', 
        duration_pages = $duration_pages, 
        year = $year, 
        rating = $rating 
        WHERE id = $id";

    if (mysqli_query($conn, $update_query)) {
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
    <title>Upraviť záznam</title>
    <style>
        body {
            font-family: 'Inter', 'Segoe UI', system-ui, sans-serif;
            background-color: #f0f4f8;
            margin: 0;
            padding: 60px 20px;
            color: #1e293b;
        }

        .container {
            max-width: 650px;
            margin: 0 auto;
        }

        .form-card {
            background: #ffffff;
            border-radius: 20px;
            padding: 45px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.06);
            /* Dynamická farba pásika podľa typu */
            border-top: 8px solid <?php echo ($row['type'] == 'kniha') ? '#10b981' : '#2563eb'; ?>;
        }

        h2 {
            font-size: 32px;
            font-weight: 900;
            color: #0f172a;
            margin-top: 0;
            margin-bottom: 35px;
            letter-spacing: -0.5px;
        }

        .form-group {
            margin-bottom: 28px;
        }

        label {
            display: block;
            font-weight: 700;
            font-size: 16px;
            color: #1e293b;
            margin-bottom: 10px;
        }

        input[type="text"],
        input[type="number"],
        select {
            width: 100%;
            padding: 16px 20px;
            box-sizing: border-box;
            border: 2px solid #cbd5e1;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 500;
            color: #0f172a;
            background-color: #f8fafc;
            transition: all 0.2s;
        }

        input:focus, select:focus {
            outline: none;
            border-color: #2563eb;
            background-color: #ffffff;
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.15);
        }

        .form-actions {
            display: flex;
            gap: 20px;
            margin-top: 40px;
        }

        .btn-submit {
            flex: 2;
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            color: white;
            border: none;
            padding: 16px 24px;
            border-radius: 12px;
            font-weight: 700;
            font-size: 16px;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
            transition: all 0.2s;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 18px rgba(37, 99, 235, 0.3);
        }

        .btn-cancel {
            flex: 1;
            background-color: #f1f5f9;
            color: #64748b;
            text-align: center;
            text-decoration: none;
            padding: 16px 24px;
            border-radius: 12px;
            font-weight: 700;
            font-size: 16px;
            transition: background 0.2s;
            box-sizing: border-box;
        }

        .btn-cancel:hover {
            background-color: #e2e8f0;
            color: #334155;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="form-card">
            <h2>Upraviť podrobnosti</h2>

            <form action="" method="POST">
                
                <div class="form-group">
                    <label>Názov:</label>
                    <input type="text" name="title" value="<?php echo htmlspecialchars($row['title']); ?>" required>
                </div>

                <div class="form-group">
                    <label>Typ média:</label>
                    <select name="type">
                        <option value="film" <?php if($row['type'] == 'film') echo 'selected'; ?>>🎬 Film</option>
                        <option value="kniha" <?php if($row['type'] == 'kniha') echo 'selected'; ?>>📖 Kniha</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Rozsah / Dĺžka (minúty alebo strany):</label>
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

                <div class="form-actions">
                    <a href="index.php" class="btn-cancel">Zrušiť</a>
                    <button type="submit" class="btn-submit">Uložiť zmeny</button>
                </div>
            </form>
        </div>
    </div>

</body>
</html>