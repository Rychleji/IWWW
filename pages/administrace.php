<?php
if (empty($_SESSION['isAdmin'])){
    header("Location:" . BASE_URL);
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
        /*$stmt = $conn->prepare("delete from :table where :column = :param");
        if(isset($_GET['cl'])){ //article
            $table = 'clanky';
            $col = 'id_clanku';
            $param = $_GET['cl'];
        }elseif(isset($_GET['uz'])){ //user
            $table = 'registrovani_uzivatele';
            $col = 'uzivatelske_jmeno';
            $param = $_GET['uz'];
        }elseif(isset($_GET['kom'])){ //comment
            $table = 'komentare';
            $col = 'id_komentare';
            $param = $_GET['kom'];
        }
        $stmt->bindParam(':table', $table);
        $stmt->bindParam(':column', $col);
        $stmt->bindParam(':param', $param);
        $stmt->execute();*/
    }
}else{
    $stmt = $conn->prepare("select * from clanky order by id_clanku asc");
    $stmt->execute(); ?>

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
        <?php }
}?>
</table>