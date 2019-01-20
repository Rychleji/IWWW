<h2>Přihlášení</h2>

<form method="post">
    <div class="container">
        <label for="username"><b>Uživatelské jméno</b></label>
        <input type="text" name="loginName" placeholder="uživatelské jméno" required>
        <label for="psw"><b>Heslo</b></label>
        <input type="password" name="loginPassword" placeholder="heslo" required>
        <hr>
        <button type="submit" class="registerbtn">Přihlásit</button>
    </div>

    <div class="container signin">
        <p>Nemáte účet? <a href="<?= BASE_URL . "?page=registrace" ?>">Registrovat se</a>.</p>
    </div>
</form>

<?php
if (!empty($_POST) && !empty($_POST["loginName"]) && !empty($_POST["loginPassword"])) {
    //connect to database
    $conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //get user by email and password
    $stmt = $conn->prepare("SELECT uzivatelske_jmeno, heslo, admin FROM " . REGUZTABULKA .
                                      " WHERE " . REGUZPK . " = :uzJm");
    $stmt->bindParam(':uzJm', $_POST["loginName"]);
    $stmt->execute();
    $user = $stmt->fetch();
    $shoda = password_verify($_POST['loginPassword'], $user['heslo']);
    if (!$user) {
        echo "user not found";
    } else if($shoda){
        echo "Welcome back: " . $user["uzivatelske_jmeno"];
        $_SESSION["username"] = $user["uzivatelske_jmeno"];
        if ($user["admin"] != 0) {
            $_SESSION["isAdmin"] = 1;
        }
        header("Location:" . BASE_URL);
    }else{
        echo "password is wrong";
    }
} else if (!empty($_POST)) {
    echo "Username and password are required";
}
?>