<?php
$conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$stmt = $conn->query("SELECT * FROM clanky ORDER BY id_clanku DESC LIMIT 9");
?>

<div class="kon_nah">
    <?php
    while ($row = $stmt->fetch()) {
        ?>

        <div class='nahled center'>
            <h3><a href="<?= BASE_URL . "?page=clanek&clanek=".$row['id_clanku'] ?>"><?php echo $row['nazev']?></a></h3>
        </div>

        <?php
    }
    ?>
</div>
