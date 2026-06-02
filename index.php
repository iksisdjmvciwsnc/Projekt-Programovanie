<?php
// Pripojenie do databázy
include 'db.php';

// 1. Načítanie iba FILMOV
$query_filmy = "SELECT * FROM media WHERE type = 'film' ORDER BY id DESC";
$result_filmy = mysqli_query($conn, $query_filmy);

// 2. Načítanie iba KNÍH
$query_knihy = "SELECT * FROM media WHERE type = 'kniha' ORDER BY id DESC";
$result_knihy = mysqli_query($conn, $query_knihy);
?>

<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Filmová a knižná knižnica</title>
    
    <style>
        body {
            font-family: 'Inter', 'Segoe UI', system-ui, sans-serif;
            background-color: #f0f4f8; 
            margin: 0;
            padding: 50px 30px; /* Viac priestoru okolo celej stránky */
            color: #1e293b;
            font-size: 16px;
        }

        .container {
            max-width: 1400px; /* Roztiahnutie stránky do šírky */
            margin: 0 auto;
        }

        /* Veľká hlavná vrchná lišta */
        .main-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 50px;
            padding-bottom: 25px;
            border-bottom: 3px solid #cbd5e1;
        }

        .main-header h1 {
            font-size: 40px; /* Masívny hlavný titulok */
            font-weight: 900;
            color: #0f172a;
            margin: 0;
            letter-spacing: -1px;
        }

        /* Veľké plné tlačidlo na pridanie záznamu */
        .btn-add {
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            color: white;
            padding: 16px 32px; /* Väčšie vnútro tlačidla */
            border-radius: 12px;
            text-decoration: none;
            font-weight: 700;
            font-size: 16px;
            box-shadow: 0 4px 14px rgba(37, 99, 235, 0.3);
            transition: all 0.2s;
        }

        .btn-add:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(37, 99, 235, 0.4);
        }

        /* Výrazné nadpisy sekcií */
        .section-title {
            font-size: 28px; /* Väčšie písmo nadpisov */
            font-weight: 800;
            color: #1e293b;
            margin: 60px 0 25px 0;
            padding-left: 15px;
            border-left: 6px solid #64748b; /* Hrubšia bočná čiara */
        }
        .section-title.film-title { border-left-color: #2563eb; }
        .section-title.kniha-title { border-left-color: #10b981; }

        /* Mriežka prispôsobená pre väčšie štvorce */
        .media-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(340px, 1fr)); /* Väčšia minimálna šírka štvorcov */
            gap: 35px; /* Viac miesta medzi štvorcami */
            margin-bottom: 50px;
        }

        /* Obrovské, plné štvorce (karty) */
        .media-card {
            background: #ffffff;
            border-radius: 20px; /* Viac zaoblené rohy */
            padding: 35px; /* Poriadna porcia miesta vo vnútri boxu */
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
            transition: transform 0.2s, box-shadow 0.2s;
            border-top: 6px solid #64748b;
            min-height: 250px; /* Vyššie boxy, aby pôsobili plne */
        }

        .media-card.card-film { border-top-color: #2563eb; }
        .media-card.card-kniha { border-top-color: #10b981; }

        .media-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        }

        /* Väčšie dizajnové štítky */
        .card-badge {
            display: inline-block;
            font-size: 12px;
            font-weight: 800;
            text-transform: uppercase;
            padding: 6px 14px;
            border-radius: 8px;
            margin-bottom: 16px;
            align-self: flex-start;
            letter-spacing: 0.5px;
        }
        .badge-film { background-color: #e0f2fe; color: #0369a1; }
        .badge-kniha { background-color: #dcfce7; color: #15803d; }

        /* Veľký výrazný názov filmu/knihy */
        .media-name {
            font-size: 24px; 
            font-weight: 800;
            color: #0f172a;
            margin: 0 0 16px 0;
            line-height: 1.3;
        }

        /* Väčšie texty s informáciami */
        .media-info {
            font-size: 16px;
            color: #475569;
            margin-bottom: 10px;
        }
        .media-info strong { color: #0f172a; font-weight: 700; }

        /* Robustnejšie hodnotenie v rohu */
        .card-rating {
            position: absolute;
            top: 25px;
            right: 25px;
            background-color: #fef9c3;
            color: #713f12;
            padding: 6px 12px;
            border-radius: 10px;
            font-weight: 800;
            font-size: 16px;
            display: flex;
            align-items: center;
            gap: 6px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }
        .star { color: #ca8a04; font-size: 18px; }

        /* Spodná akčná časť s väčšími tlačidlami */
        .card-actions {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 2px solid #f1f5f9;
            display: flex;
            justify-content: space-between;
        }

        .card-actions a {
            text-decoration: none;
            font-weight: 700;
            font-size: 15px;
            padding: 10px 20px;
            border-radius: 8px;
            transition: all 0.2s;
        }

        .btn-edit { color: #2563eb; background-color: #eff6ff; }
        .btn-edit:hover { background-color: #dbeafe; }
        .btn-delete { color: #ef4444; background-color: #fef2f2; }
        .btn-delete:hover { background-color: #fee2e2; }

        .empty-text {
            color: #64748b;
            font-style: italic;
            grid-column: 1 / -1;
            background: white;
            padding: 30px;
            border-radius: 16px;
            text-align: center;
            font-size: 16px;
        }
    </style>
</head>
<body>

    <div class="container">

        <div class="main-header">
            <h1>Moja Knižnica médií</h1>
            <a href="create.php" class="btn-add">+ Pridať nový záznam</a>
        </div>

        <div class="section-title film-title">🎬 Filmy</div>
        <div class="media-grid">
            <?php
            if (mysqli_num_rows($result_filmy) > 0) {
                while ($row = mysqli_fetch_assoc($result_filmy)) {
                    ?>
                    <div class="media-card card-film">
                        <div class="card-rating">
                            <span class="star">★</span>
                            <span><?php echo number_format($row['rating'], 1); ?></span>
                        </div>
                        <div>
                            <span class="card-badge badge-film">Film</span>
                            <h3 class="media-name"><?php echo htmlspecialchars($row['title']); ?></h3>
                            <div class="media-info">Rok vydania: <strong><?php echo $row['year']; ?></strong></div>
                            <div class="media-info">Dĺžka filmu: <strong><?php echo intval($row['duration_pages']); ?> min</strong></div>
                        </div>
                        <div class="card-actions">
                            <a href="update.php?id=<?php echo $row['id']; ?>" class="btn-edit">Upraviť</a>
                            <a href="delete.php?id=<?php echo $row['id']; ?>" class="btn-delete" onclick="return confirm('Naozaj vymazať tento film?');">Vymazať</a>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo "<div class='empty-text'>V databáze nie sú žiadne filmy.</div>";
            }
            ?>
        </div>

        <div class="section-title kniha-title">📖 Knihy</div>
        <div class="media-grid">
            <?php
            if (mysqli_num_rows($result_knihy) > 0) {
                while ($row = mysqli_fetch_assoc($result_knihy)) {
                    ?>
                    <div class="media-card card-kniha">
                        <div class="card-rating">
                            <span class="star">★</span>
                            <span><?php echo number_format($row['rating'], 1); ?></span>
                        </div>
                        <div>
                            <span class="card-badge badge-kniha">Kniha</span>
                            <h3 class="media-name"><?php echo htmlspecialchars($row['title']); ?></h3>
                            <div class="media-info">Rok vydania: <strong><?php echo $row['year']; ?></strong></div>
                            <div class="media-info">Počet strán: <strong><?php echo intval($row['duration_pages']); ?> str</strong></div>
                        </div>
                        <div class="card-actions">
                            <a href="update.php?id=<?php echo $row['id']; ?>" class="btn-edit">Upraviť</a>
                            <a href="delete.php?id=<?php echo $row['id']; ?>" class="btn-delete" onclick="return confirm('Naozaj vymazať túto knihu?');">Vymazať</a>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo "<div class='empty-text'>V databáze nie sú žiadne knihy.</div>";
            }
            ?>
        </div>

    </div>

</body>
</html>