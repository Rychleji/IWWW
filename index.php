<?php
ob_start();
session_start();
include "config.php";
?>

<head>
    <meta charset="UTF-8">
    <title><?= PAGETITLE;?></title>
    <link rel="stylesheet" type="text/css" href="../css/main.css">
</head>
<body>
<header>
    <div class="login_management full_width_wrapper right">
        <?php if (!empty($_SESSION["username"])) { ?>
            <a href="<?= BASE_URL . "?page=profil" ?>"><?= $_SESSION["username"]?></a>
            <a href="<?= BASE_URL . "?page=logout" ?>">Logout</a>
        <?php } else { ?>
            <a href="<?= BASE_URL . "?page=prihlaseni" ?>">Přihlášení</a>
            <a href="<?= BASE_URL . "?page=registrace" ?>">Registrace</a>
        <?php } ?>

    </div>
    <div class="header_box_bg header_box">
            <div id="header_web_title"><h1><?= PAGETITLE; ?></h1></div>
            <nav id="navigation">
                <a href="<?= BASE_URL ?>">Úvod</a>
                <a href="<?= BASE_URL . "?page=tagy" ?>">Tagy</a>
                <?php if (!empty($_SESSION["username"])) { ?>
                    <a href="<?= BASE_URL . "?page=tvorbaclanku" ?>">Přidat článek</a>
                <?php }?>
                <?php if (!empty($_SESSION["isAdmin"])) { ?>
                    <a href="<?= BASE_URL . "?page=administrace" ?>">administrace</a>
                <?php }?>
                <hr>
            </nav>
    </div>
</header>
<main>
    <?php
    if (isset($_GET["page"])) {
        $file = "./pages/" . $_GET["page"] . ".php";
        if (file_exists($file)) {
            include $file;
        }
    } else {
        include "./pages/landing.php";
    }
    ?>
</main>
<footer>
    <div class="full_width_wrapper">
        <h3>Radim Nyč</h3>
    </div>
</footer>
</body>
</html>