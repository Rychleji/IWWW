<?php
$conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$stmt = $conn->prepare("select * from registrovani_uzivatele where uzivatelske_jmeno = :jmeno");

if (!empty($_GET['uzivatel'])){
    $stmt->bindParam(':jmeno', $_GET['uzivatel']);
}else if(!empty($_SESSION['username'])){ //profil přihlášeného
    $stmt->bindParam(':jmeno', $_SESSION['username']);
}

$stmt->execute();
$select = $stmt->fetch();
?>

<div class="kon_profil">
    <div>
        <h2><?php echo $select['uzivatelske_jmeno'];?></h2>
        <p>e-mail: <?php echo $select['email'];?></p>
        <p>Jméno: <?php echo $select['jmeno_prijmeni'];?></p>
        <p>Registrace: <?php echo $select['registrace'];?></p>
        <a href="<?= BASE_URL . "?page=oblibeneclanky&uzivatel=". $select['uzivatelske_jmeno']?>">Oblíbené články</a>
    </div>
</div>
