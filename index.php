<?php
include "config.php";
?>

<head>
    <meta charset="UTF-8">
    <title><?= PAGETITLE;?></title>
</head>
<body>
<h1><?= PAGETITLE; ?></h1>

<a href=<?=TVORBACLANKUURL?>>Přidat článek</a>
<a href=<?=PROFILURL?>>Uživatelský profil</a>
<a href=<?=PRIHLASENIURL?>>Přihlášení</a>

</body>
</html>

<?php
//echo password_hash("rasmuslerdorf", PASSWORD_BCRYPT);
?>