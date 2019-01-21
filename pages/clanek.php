<!-- CSS rules for styling the element inside the editor such as p, h1, h2, etc. -->
<link href="../css/froala_style.min.css" rel="stylesheet" type="text/css" />

<?php
$conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$stmt = $conn->prepare("SELECT * FROM clanky c left join registrovani_uzivatele u on u.uzivatelske_jmeno = c.autor_uzivatelske_jmeno WHERE id_clanku = :idCl");

$stmt->bindParam(':idCl', $_GET["clanek"]);
$stmt->execute();
$clanek = $stmt->fetch();
?>

<article class="clanek">
    <h3 class="center nadpis"><?php echo $clanek['nazev']; ?></h3>
    <a href="<?= "pages/export.php?cl=".$_GET["clanek"] ?>"><img class="icons" src="pic/XMLico.png" alt="XML"/></a>
    <?php
    $stmt01 = $conn->prepare("SELECT * FROM oblibene_clanky WHERE clanky_id = :idCl AND uzivatelske_jmeno_clena = :uz");

    $stmt01->bindParam(':idCl', $_GET["clanek"]);
    $stmt01->bindParam(':uz', $_SESSION["username"]);
    $stmt01->execute();
    $ob = $stmt01->fetch();

    if(empty($ob)){
        ?>
        <div class="right">
            <a class="oblibene" href="<?= BASE_URL . "?page=pridatdooblibenych&c=".$clanek['id_clanku'] ?>">Přidat do oblíbených</a>
        </div>
    <?php } ?>
    <br>
    <div class="fr-view">
        <?php echo $clanek['text_clanku']; ?>
    </div>
    <div class="right">
        <a href="<?= BASE_URL . "?page=profil&uzivatel=".$clanek['autor_uzivatelske_jmeno'] ?>"><?= $clanek['jmeno_prijmeni']?></a>
    </div>

</article>

<hr/>

<form method="post">
    <div class="container">
        <label for="komentar"><b>Komentář:</b></label>
        <input type="text" name="komentar" required>

        <hr>
        <button type="submit" class="right">Odeslat</button>
    </div>
</form>

<br/>

<?php
if (!empty($_POST)) {
    $stmt2 = $conn->prepare("select max(id_komentare)+1 as vysl from komentare");
    $stmt2->execute();
    $select = $stmt2->fetch();
    $idKomentare = $select['vysl'];
    $stmt = $conn->prepare("INSERT INTO komentare(id_komentare, text_kom, clanky_id, autor_uzivatelske_jmeno, komentare_id_komentare) 
        values (:id, :text, :clanek, :autor, :prKom)");
    $stmt->bindParam(":id", $idKomentare);
    $stmt->bindParam(':text', $_POST["komentar"]);
    $stmt->bindParam(':clanek', $_GET['clanek']);
    if (empty($_SESSION["username"])){
        $autor = null;
    }else{
        $autor = $_SESSION["username"];
    }
    $stmt->bindParam(':autor', $autor);
    $stmt->bindParam(':prKom', $_POST['pred_kom']);
    $stmt->execute();
}
?>

<div id='comments'>
    <h4>Komentáře</h4>
    <?php
    $stmt = $conn->prepare("SELECT * FROM komentare WHERE clanky_id = :idCl AND komentare_id_komentare IS NULL ORDER BY pridano ASC");
    $stmt->bindParam(":idCl", $_GET['clanek']);
    $stmt->execute();

    while ($row = $stmt->fetch()) {
        ?>
        <div class='cmmnt'>
            <p class='cmmnt-content pubdate'><?php echo $row['pridano'] ?></p>
            <p class='cmmnt-content'><?php echo $row['text_kom'] ?></p>
            <a href="<?= BASE_URL . "?page=profil&uzivatel=".$row['autor_uzivatelske_jmeno'] ?>" class='cmmnt-content userlink'><?= $row['autor_uzivatelske_jmeno']?></a>
            <a href="<?= BASE_URL . "?page=odpoved&kom=" . $row['id_komentare']."&cl=".$_GET['clanek']?>" class='cmmnt-content'>Odpovědět</a>
            <?php if(!empty($_SESSION["isAdmin"])){?>
            <a href="<?= BASE_URL . "?page=administrace&ed=1&kom=" . $row['id_komentare']?>" class='cmmnt-content'>Smazat</a>
            <?php } ?>
            <br/>
            <?php
            $stmt2 = $conn->prepare("SELECT * FROM komentare WHERE komentare_id_komentare = :idKom ORDER BY pridano ASC");
            $stmt2->bindParam(":idKom", $row['id_komentare']);
            $stmt2->execute();
            while ($row2 = $stmt2->fetch()) {
                ?>

                <div class='cmmnt replies'>
                    <p class='cmmnt-content pubdate'><?php echo $row2['pridano'] ?></p>
                    <p class='cmmnt-content'><?php echo $row2['text_kom'] ?></p>
                    <a href="<?= BASE_URL . "?page=profil&uzivatel=".$row2['autor_uzivatelske_jmeno'] ?>" class='cmmnt-content userlink'><?= $row2['autor_uzivatelske_jmeno']?></a>
                    <?php if(!empty($_SESSION["isAdmin"])){?>
                        <a href="<?= BASE_URL . "?page=administrace&ed=1&kom=" . $row2['id_komentare']?>" class='cmmnt-content'>Smazat</a>
                    <?php } ?>
                </div>
                <br/>

            <?php } ?>

        </div>
        <br/>
    <?php } ?>
</div>