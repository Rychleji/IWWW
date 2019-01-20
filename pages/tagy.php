<?php
$conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>

<div class="kon_nah">
    <?php
    if(!empty($_GET['tag'])){
        $stmt = $conn->prepare("SELECT * FROM clanky left join clanky_has_tagy on clanky.id_clanku = clanky_has_tagy.clanky_id_clanku where tagy_tag = :tag");
        $stmt->bindParam(":tag", $_GET['tag']);
        $stmt->execute();

        echo "<h3>".$_GET['tag']."</h3>";

        while ($row = $stmt->fetch()) {
            ?>

            <div class='nahled center'>
                <h3><a href="<?= BASE_URL . "?page=clanek&clanek=".$row['id_clanku'] ?>"><?php echo $row['nazev']?></a></h3>
            </div>

            <?php
        }
    }else{
        $stmt = $conn->query("SELECT * FROM tagy");
        while ($row = $stmt->fetch()) {
            ?>

            <div class='nahled center'>
                <h3><a href="<?= BASE_URL . "?page=tagy&tag=".$row['tag'] ?>"><?php echo $row['tag']?></a></h3>
            </div>

            <?php
        }
    }
    ?>
</div>
