<?php
include_once 'config.php';
?>
<h2>Registrace</h2>

<form method="post">
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
        <p>Již máte účet? <a href="<?= BASE_URL . "?page=prihlaseni" ?>">Přihlásit se</a>.</p>
    </div>
</form>

<?php
if (!empty($_POST)) {
    //connect to database
    $conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //get user by email and password
    $newPass = password_hash($_POST["psw"], PASSWORD_BCRYPT);
    $stmt = $conn->prepare("INSERT INTO " . REGUZTABULKA . "(uzivatelske_jmeno, email, jmeno_prijmeni, heslo) 
        values (:uzJm, :email, :jmPr, :pass )");
    $stmt->bindParam(':uzJm', $_POST["username"]);
    $stmt->bindParam(':email', $_POST["email"]);
    $stmt->bindParam(':jmPr', $_POST["name"]);
    $stmt->bindParam(':pass', $newPass);
    $stmt->execute();

    /*$shoda = $_POST["loginPassword"] == $user["heslo"];
    if (!$user) {
        echo "user not found";
    } else if($shoda){
        echo "Welcome back: " . $user["uzivatelske_jmeno"];
        $_SESSION["username"] = $user["uzivatelske_jmeno"];
        $_SESSION["email"] = $user["email"];
        header("Location:" . BASE_URL);
    }else{
        echo "password is wrong";
    }*/
}
?>