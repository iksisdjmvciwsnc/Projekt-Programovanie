<?php
include "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'] ?? '';
    $type = $_POST['type'] ?? 'film';
    $year = !empty($_POST['year']) ? intval($_POST['year']) : 0;
    $rating = !empty($_POST['rating']) ? floatval($_POST['rating']) : 0.0;
    $duration_pages = !empty($_POST['duration_pages']) ? intval($_POST['duration_pages']) : 0;

    if (!empty($title)) {
        $title_escaped = $conn->real_escape_string($title);
        $type_escaped = $conn->real_escape_string($type);

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
    <title>Pridať nový záznam</title>
    <style>
        body {
            font-family: 'Inter', 'Segoe UI', system-ui, sans-serif;
            background-color: #f0f4f8;
            margin: 0;
            padding: 60px 20px;
            color: #1e293b;
        }

        .container {
            max-width: 650px; /* Perfektná šírka pre plný formulár */
            margin: 0 auto;
        }

        .form-card {
            background: #ffffff;
            border-radius: 20px;
            padding: 45px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.06);
            border-top: 8px solid #2563eb; /* Masívny modrý akcent */
            transition: border-color 0.3s ease;
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
        <div class="form-card" id="form-card">
            <h2>Pridať nový film alebo knihu</h2>
            
            <form method="POST" action="">
                <div class="form-group">
                    <label>Názov diela:</label>
                    <input type="text" name="title" placeholder="Napr. Interstellar, Harry Potter..." required>
                </div>

                <div class="form-group">
                    <label>Typ média:</label>
                    <select name="type" id="media-type" onchange="obnovPolickoDlzky()">
                        <option value="film">🎬 Film</option>
                        <option value="kniha">📖 Kniha</option>
                    </select>
                </div>

                <div class="form-group">
                    <label id="dlzka-label">Dĺžka filmu (v minútach):</label>
                    <input type="number" name="duration_pages" placeholder="Napr. 169" min="0">
                </div>

                <div class="form-group">
                    <label>Rok vydania:</label>
                    <input type="number" name="year" placeholder="Napr. 2014">
                </div>

                <div class="form-group">
                    <label>Hodnotenie (0.0 - 10.0):</label>
                    <input type="number" name="rating" placeholder="Napr. 8.6" min="0" max="10" step="0.1">
                </div>

                <div class="form-actions">
                    <a href="index.php" class="btn-cancel">Zrušiť</a>
                    <button type="submit" class="btn-submit">Pridať do databázy</button>
                </div>
            </form>
        </div>
    </div>

    <script>
    function obnovPolickoDlzky() {
        var selectType = document.getElementById("media-type").value;
        var label = document.getElementById("dlzka-label");
        var card = document.getElementById("form-card");
        
        if (selectType === "kniha") {
            label.innerText = "Počet strán knihy:";
            card.style.borderTopColor = "#10b981"; /* Zelená pre knihu */
        } else {
            label.innerText = "Dĺžka filmu (v minútach):";
            card.style.borderTopColor = "#2563eb"; /* Modrá pre film */
        }
    }
    </script>
</body>
</html>