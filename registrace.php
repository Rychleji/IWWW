<?php
include 'config.php';
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?=PAGETITLE;?></title>
    <link rel="stylesheet" type="text/css" href="registrace.css">
</head>
<body>
<h1>Registrace</h1>

<form action="action_page.php">
    <div class="container">
        <label for="username"><b>Uživatelské jméno:</b></label>
        <input type="text" placeholder="Uživatelské jméno" name="username" required>

        <label for="psw"><b>Heslo:</b></label>
        <input type="password" placeholder="Heslo" name="psw" required>

        <label for="psw-repeat"><b>Heslo znovu:</b></label>
        <input type="password" placeholder="Heslo" name="psw-repeat" required>
        <hr>

        <button type="submit" class="registerbtn">Registrovat</button>
    </div>

    <div class="container signin">
        <p>Již máte účet? <a href="prihlaseni.php">Přihlásit</a>.</p>
    </div>
</form>

</body>
</html>

