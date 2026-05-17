
<?php
include "db.php";

$id = $_GET['id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $type = $_POST['type'];
    $year = $_POST['year'];
    $rating = $_POST['rating'];

    $conn->query("UPDATE media SET 
        title='$title',
        type='$type',
        year='$year',
        rating='$rating'
        WHERE id=$id");

    header("Location: index.php");
}

$result = $conn->query("SELECT * FROM media WHERE id=$id");
$row = $result->fetch_assoc();
?>

<form method="POST">
    <input type="text" name="title" value="<?php echo $row['title']; ?>"><br>

    <select name="type">
        <option value="film" <?php if($row['type']=="film") echo "selected"; ?>>Film</option>
        <option value="kniha" <?php if($row['type']=="kniha") echo "selected"; ?>>Kniha</option>
    </select><br>

    <input type="number" name="year" value="<?php echo $row['year']; ?>"><br>
    <input type="number" name="rating" value="<?php echo $row['rating']; ?>"><br>

    <button>Uložiť</button>
<?php
include "db.php";

$id = $_GET['id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $type = $_POST['type'];
    $year = $_POST['year'];
    $rating = $_POST['rating'];

    $conn->query("UPDATE media SET 
        title='$title',
        type='$type',
        year='$year',
        rating='$rating'
        WHERE id=$id");

    header("Location: index.php");
}

$result = $conn->query("SELECT * FROM media WHERE id=$id");
$row = $result->fetch_assoc();
?>

<form method="POST">
    <input type="text" name="title" value="<?php echo $row['title']; ?>"><br>

    <select name="type">
        <option value="film" <?php if($row['type']=="film") echo "selected"; ?>>Film</option>
        <option value="kniha" <?php if($row['type']=="kniha") echo "selected"; ?>>Kniha</option>
    </select><br>

    <input type="number" name="year" value="<?php echo $row['year']; ?>"><br>
    <input type="number" name="rating" value="<?php echo $row['rating']; ?>"><br>

    <button>Uložiť</button>

</form>