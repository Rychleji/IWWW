<?php
define('PAGETITLE', 'Studentské noviny!');
define('CLANEKURL', 'clanek.php');
define('INDEXURL', 'index.php');
define('OBLIBCLANKYURL', 'oblibeneclanky.php');
define('PRIHLASENIURL', 'prihlaseni.php');
define('PROFILURL', 'profil.php');
define('TAGYURL', 'tagy.php');
define('TVORBACLANKUURL', 'tvorbaclanku.php');

//Uživatelé
define('REGUZTABULKA', 'registrovani_uzivatele');
define('REGUZPK', 'uzivatelske_jmeno');

//databaze
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'sempr');
define('BASE_URL', parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH));
define('CURRENT_URL', $_SERVER['SCRIPT_NAME'] . '?' . $_SERVER['QUERY_STRING']);
