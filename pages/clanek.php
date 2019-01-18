<!-- CSS rules for styling the element inside the editor such as p, h1, h2, etc. -->
<link href="../css/froala_style.min.css" rel="stylesheet" type="text/css" />

<?php
$conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$stmt = $conn->prepare("SELECT * FROM clanky WHERE id_clanku = :idCl");

$stmt->bindParam(':idCl', $_GET["clanek"]);
$stmt->execute();
$clanek = $stmt->fetch();
?>
<h3><?php echo $clanek['nazev']; ?></h3>
<div class="fr-view">
    <?php echo $clanek['text_clanku']; ?>
</div>