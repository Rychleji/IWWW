<?php
include "config.php";
?>

<head>
    <meta charset="UTF-8">
    <title><?= PAGETITLE;?></title>
</head>
<body>
<header>
    <div class="user-area">
        <div class="full-width-wrapper">
            <a href="<?= BASE_URL . "?page=prihlaseni" ?>">Přihlášení</a>
            <a href="<?= BASE_URL . "?page=registrace" ?>">Registrace</a>
        </div>
    </div>
    <div class="header-box-bg">
        <div class="header-box">
            <div id="header-logo-box">
                <img id="header-logo" src="img/logo-dynamo.png" alt="Dynamo Logo"></div>
            <div id="header-web-title"><h1><?= PAGETITLE; ?></h1></div>
            <nav id="nav">
                <a id="first" href="<?= BASE_URL ?>">Úvod</a>
                <a id="second" href="<?= BASE_URL . "?page=tagy" ?>">Tagy</a>
                <a id="third" href="<?= BASE_URL . "?page=tvorbaclanku" ?>">Přidat článek</a>
                <a id="fourth" href="<?= BASE_URL . "?page=profil" ?>">Profil</a>
                <hr>
            </nav>
        </div>
    </div>
</header>
<?php
if (!isset($_GET["page"])) {
    include "landing.php";
}
?>
<main>
    <?php
    if (isset($_GET["page"])) {
        $file = "" . $_GET["page"] . ".php";
        if (file_exists($file)) {
            include $file;
        }
    } else {
        include "cnf.php";
    }
    ?>
</main>
<footer>
    <div class="full-width-wrapper">
        konec stranky ..
    </div>
</footer>
</body>
</html>

<?php
//echo password_hash("rasmuslerdorf", PASSWORD_BCRYPT);
?>