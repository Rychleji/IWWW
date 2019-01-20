<?php
$conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$stmt = $conn->prepare("select * from oblibene_clanky o left join clanky c on o.clanky_id = c.id_clanku where o.uzivatelske_jmeno_clena = :jmeno");
$stmt->bindParam(':jmeno', $_GET['uzivatel']);
$stmt->execute();

while ($row = $stmt->fetch()) {
    ?>
    <a href="<?= BASE_URL . "?page=clanek&clanek=".$row['id_clanku'] ?>"><?= $row['nazev']?></a>
    <?php
}
?>
