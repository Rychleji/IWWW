<?php
include "config.php";
?>

<head>
    <meta charset="UTF-8">
    <title><?= PAGETITLE;?></title>
    <link rel="stylesheet" type="text/css" href="../css/main.css">
</head>
<body>
<header>
    <div class="login_management full_width_wrapper">
        <a href="<?= BASE_URL . "?page=prihlaseni" ?>">Přihlášení</a>
        <a href="<?= BASE_URL . "?page=registrace" ?>">Registrace</a>
    </div>
    <div class="header_box_bg header_box">
            <div id="header_web_title"><h1><?= PAGETITLE; ?></h1></div>
            <nav id="navigation">
                <a href="<?= BASE_URL ?>">Úvod</a>
                <a href="<?= BASE_URL . "?page=tagy" ?>">Tagy</a>
                <a href="<?= BASE_URL . "?page=tvorbaclanku" ?>">Přidat článek</a>
                <a href="<?= BASE_URL . "?page=profil" ?>">Profil</a>
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
        konec stranky ..
    </div>
</footer>
</body>
</html>

<?php
//echo password_hash("rasmuslerdorf", PASSWORD_BCRYPT);
?>