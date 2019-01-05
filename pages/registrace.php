<?php
include_once 'config.php';
?>
<head><link rel="stylesheet" type="text/css" href="../css/registrace.css"></head>

<h1>Registrace</h1>

<form action="action_page.php">
    <div class="container">
        <label for="username"><b>Uživatelské jméno:</b></label>
        <input type="text" placeholder="Uživatelské jméno" name="username" required>

        <label for="psw"><b>Heslo:</b></label>
        <input type="password" placeholder="Heslo" name="psw" required>

        <label for="psw-repeat"><b>Heslo znovu:</b></label>
        <input type="password" placeholder="Heslo" name="psw-repeat" required>

        <label for="name"><b>Jméno a příjmení:</b></label>
        <input type="text" placeholder="Jméno Příjmení" name="name" required>

        <label for="email"><b>email:</b></label>
        <input type="email" placeholder="something@domain.co" name="email" required>
        <hr>

        <button type="submit" class="registerbtn">Registrovat</button>
    </div>

    <div class="container signin">
        <p>Již máte účet? <a href="prihlaseni.php">Přihlásit</a>.</p>
    </div>
</form>