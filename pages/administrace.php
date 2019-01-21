<?php
if (empty($_SESSION['isAdmin'])){
    header("Location:" . BASE_URL);
    exit();
}

$conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if(!empty($_GET['ed'])){
    if($_GET['ed'] == 1) { //erase
        if(isset($_GET['cl'])){ //article
            $stmt = $conn->prepare('delete from clanky where id_clanku = :param');
            $stmt->bindParam(':param',  $_GET['cl']);
        }elseif(isset($_GET['uz'])){ //user
            $stmt = $conn->prepare('delete from registrovani_uzivatele where uzivatelske_jmeno = :param');
            $stmt->bindParam(':param',  $_GET['uz']);
        }elseif(isset($_GET['kom'])){ //comment
            $stmt = $conn->prepare('delete from komentare where id_komentare = :param');
            $stmt->bindParam(':param',  $_GET['kom']);
        }

        $stmt->execute();
        header("Location:" . BASE_URL . "?page=administrace");
    }else{ //edit
        if(isset($_GET['cl'])){ //article
            $stmt = $conn->prepare("select * from clanky where id_clanku=:id");
            $stmt->bindParam(':id', $_GET['cl']);
            $stmt->execute();
            $clanek = $stmt->fetch();

            $stmt2= $conn->prepare("select * from clanky_has_tagy where clanky_id_clanku = :clanek");
            $stmt2->bindParam(':clanek', $clanek['id_clanku']);
            $stmt2->execute();

            $row = $stmt2->fetch();

            $tagy = $row['tagy_tag'];
            while ($row = $stmt2->fetch()) {
                $tagy = $tagy . ';' . $row['tagy_tag'];
            }

            $tagy = trim($tagy);

            ?>
            <form method="post">
                <div>
                    <label for="name"><b>Název:</b></label>
                    <input type="text" name="name" value='<?PHP echo $clanek['nazev']; ?>' required>
                    <br/>
                    <label for="author"><b>Autor:</b></label>
                    <input type="text" name="author" value='<?PHP echo $clanek['autor_uzivatelske_jmeno']; ?>' required>
                    <br/>
                    <label for="textC"><b>Text:</b></label>
                    <input type="text" name="textC" value='<?PHP echo $clanek['text_clanku']; ?>' required>
                    <br/>
                    <label for="tagy"><b>Tagy:</b></label>
                    <input type="text" name="tagy" value='<?PHP echo $tagy; ?>' required>
                    <hr/>

                    <button type="submit">Uložit</button>
                </div>
            </form>
            <?php
        }elseif(isset($_GET['uz'])){ //user
            $stmt = $conn->prepare("select * from registrovani_uzivatele where uzivatelske_jmeno=:id");
            $stmt->bindParam(':id', $_GET['uz']);
            $stmt->execute();
            $uzivatel = $stmt->fetch();
            ?>
            <form method="post">
                <div>
                    <label for="user"><b>Uživatelské jméno:</b></label>
                    <input type="text" name="user" value='<?PHP echo $_GET['uz']; ?>' required>
                    <br/>
                    <label for="name"><b>Jméno a příjmení:</b></label>
                    <input type="text" name="name" value='<?PHP echo $uzivatel['jmeno_prijmeni']; ?>' required>
                    <br/>
                    <label for="mail"><b>e-mail:</b></label>
                    <input type="email" name="mail" value='<?PHP echo $uzivatel['email']; ?>' required>

                    <hr/>

                    <button type="submit">Uložit</button>
                </div>
            </form>
            <?php
        }elseif(isset($_GET['kom'])){ //comment
            $stmt = $conn->prepare("select * from komentare where id_komentare=:id");
            $stmt->bindParam(':id', $_GET['kom']);
            $stmt->execute();
            $komentar = $stmt->fetch();
            ?>
            <form method="post">
                <div>
                    <input type="text" name="textK" value='<?PHP echo $komentar['text_kom']; ?>' required>
                    <label for="textK"><b>Text:</b></label>
                    <br/>
                    <input type="number" name="clanekID" value='<?PHP echo $komentar['clanky_id']; ?>' required>
                    <label for="clanekID"><b>Článek:</b></label>
                    <br/>
                    <input type="text" name="authorK" value='<?PHP echo $komentar['autor_uzivatelske_jmeno']; ?>'>
                    <label for="authorK"><b>Autor:</b></label>
                    <br/>
                    <input type="text" name="reactionTo" value='<?PHP echo $komentar['komentare_id_komentare']; ?>'>
                    <label for="reactionTo"><b>Reakce na:</b></label>

                    <hr/>

                    <button type="submit">Uložit</button>
                </div>
            </form>
            <?php
        }
    }
}else{
    $stmt = $conn->prepare("select * from clanky order by id_clanku asc");
    $stmt->execute(); ?>

    <a href="<?= "pages/export.php" ?>"><img class="icons" style="margin: 3px" src="pic/XMLico.png" alt="XML"/></a>
    <a href="<?= BASE_URL . "?page=import" ?>"><img class="icons" style="margin: 3px" src="pic/importico.png" alt="import"/></a>
    <table class='tb1' style="width:100%">
        <caption style='text-align: left'><b>Articles</b></caption>
        <tr>
            <th>Name</th>
            <th>Author</th>
            <th>ID</th>
            <th>Edit</th>
            <th>Erase</th>
        </tr>
        <?php
        while ($row = $stmt->fetch()) {
            ?>
            <tr>
                <td><?php echo $row['nazev'] ?></td>
                <td><?php echo $row['autor_uzivatelske_jmeno'] ?></td>
                <td><?php echo $row['id_clanku'] ?></td>
                <td><a href="<?= BASE_URL . "?page=administrace&ed=2&cl=" . $row['id_clanku'] ?>">EDIT</a></td>
                <td><a href="<?= BASE_URL . "?page=administrace&ed=1&cl=" . $row['id_clanku'] ?>">ERASE</a></td>
            </tr>
        <?php } ?>
    </table>
    <a href="<?= BASE_URL . "?page=clanek&clanek=" . $row['id_clanku'] ?>"><?= $row['nazev'] ?></a>
    <?php
    $stmt = $conn->prepare("select * from registrovani_uzivatele where admin = 0 order by uzivatelske_jmeno asc");
    $stmt->execute(); ?>

    <table class='tb1' style="width:100%">
        <caption style='text-align: left'><b>Users</b></caption>
        <tr>
            <th>Username</th>
            <th>Name</th>
            <th>E-mail</th>
            <th>Registration</th>
            <th>Edit</th>
            <th>Erase</th>
        </tr>
        <?php
        while ($row = $stmt->fetch()) {
            ?>
            <tr>
                <td><?php echo $row['uzivatelske_jmeno'] ?></td>
                <td><?php echo $row['jmeno_prijmeni'] ?></td>
                <td><?php echo $row['email'] ?></td>
                <td><?php echo $row['registrace'] ?></td>
                <td><a href="<?= BASE_URL . "?page=administrace&ed=2&uz=" . $row['uzivatelske_jmeno'] ?>">EDIT</a></td>
                <td><a href="<?= BASE_URL . "?page=administrace&ed=1&uz=" . $row['uzivatelske_jmeno'] ?>">ERASE</a></td>
            </tr>
        <?php } ?>
    </table>

    <?php
    $stmt = $conn->prepare("select * from komentare order by id_komentare asc");
    $stmt->execute(); ?>

    <table class='tb1' style="width:100%">
        <caption style='text-align: left'><b>Comments</b></caption>
        <tr>
            <th>Article ID</th>
            <th>Comment ID</th>
            <th>Author</th>
            <th>Added</th>
            <th>Reply to</th>
            <th>Edit</th>
            <th>Erase</th>
        </tr>
        <?php
        while ($row = $stmt->fetch()) {
            ?>
            <tr>
                <td><?php echo $row['clanky_id'] ?></td>
                <td><?php echo $row['id_komentare'] ?></td>
                <td><?php echo $row['autor_uzivatelske_jmeno'] ?></td>
                <td><?php echo $row['pridano'] ?></td>
                <td><?php echo $row['komentare_id_komentare'] ?></td>
                <td><a href="<?= BASE_URL . "?page=administrace&ed=2&kom=" . $row['id_komentare'] ?>">EDIT</a></td>
                <td><a href="<?= BASE_URL . "?page=administrace&ed=1&kom=" . $row['id_komentare'] ?>">ERASE</a></td>
            </tr>
        <?php } ?>
    </table>
<?php } ?>

<?php
if(!empty($_POST)){
    if(isset($_GET['cl'])){
        $stmt = $conn->prepare("update clanky set nazev = :nazev, text_clanku = :text, autor_uzivatelske_jmeno = :autor where id_clanku = :id");
        $stmt->bindParam(':id', $_GET['cl']);
        $stmt->bindParam(':nazev', $_POST['name']);
        $stmt->bindParam(':text', $_POST['textC']);
        $stmt->bindParam(':autor', $_POST['author']);

        $stmt2 = $conn->prepare("DELETE FROM clanky_has_tagy where clanky_id_clanku = :cl");
        $stmt2->bindParam(':cl', $_GET['cl']);
        $stmt2->execute();

        $tags = explode(";", $_POST["tagy"]);

        foreach ($tags as $tag) {
            $pTag = trim($tag);
            try {
                $stmt2 = $conn->prepare("INSERT INTO tagy values (:tag)");
                $stmt2->bindParam(":tag", $pTag);
                $stmt2->execute();
            } catch (Exception $e) { }

            $stmt3 = $conn->prepare("INSERT INTO clanky_has_tagy values (:idCl, :tag)");
            $stmt3->bindParam(":idCl", $_GET['cl']);
            $stmt3->bindParam(":tag", $pTag);
            $stmt3->execute();
        }
    }elseif(isset($_GET['uz'])){
        $stmt = $conn->prepare("update registrovani_uzivatele set uzivatelske_jmeno = :un, jmeno_prijmeni = :jmeno, email = :email where uzivatelske_jmeno = :puvUn");
        $stmt->bindParam(':un', $_POST['user']);
        $stmt->bindParam(':jmeno', $_POST['name']);
        $stmt->bindParam(':email', $_POST['mail']);
        $stmt->bindParam(':puvUn', $_GET['uz']);
    }elseif(isset($_GET['kom'])){
        $stmt = $conn->prepare("update komentare set clanky_id = :clanek, text_kom = :text, autor_uzivatelske_jmeno = :autor, komentare_id_komentare = :komentar where id_komentare = :id");
        $reakce = null;
        if(!empty($_POST['reactionTo']))
            $reakce = $_POST['reactionTo'];
        $stmt->bindParam(':id', $_GET['kom']);
        $stmt->bindParam(':clanek', $_POST['clanekID']);
        $stmt->bindParam(':text', $_POST['textK']);
        $stmt->bindParam(':autor', $_POST['authorK']);
        $stmt->bindParam(':komentar', $reakce);
    }
    $stmt->execute();
    header("Location:" . BASE_URL . "?page=administrace");
}
?>