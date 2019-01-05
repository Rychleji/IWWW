<?php
include_once 'config.php';
?>

<h1>Přihlášení</h1>

<form method="post">
    <input type="text" name="loginName" placeholder="Insert your email">
    <input type="password" name="loginPassword" placeholder="Password">
    <input type="submit" value="Log in">
</form>

<?php
if (!empty($_POST) && !empty($_POST["loginName"]) && !empty($_POST["loginPassword"])) {

    //connect to database
    $conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //get user by email and password
    $stmt = $conn->prepare("SELECT uzivatelske_jmeno, heslo, email FROM " . REGUZTABULKA .
                                      " WHERE " . REGUZPK . " = :uzJm");
    $stmt->bindParam(':uzJm', $_POST["loginName"]);
    $stmt->execute();
    $user = $stmt->fetch();
    $shoda = $_POST["loginPassword"] == $user["heslo"];
    if (!$user) {
        echo "user not found";
    } else if($shoda){
        echo "Welcome back: " . $user["uzivatelske_jmeno"];
        $_SESSION["username"] = $user["uzivatelske_jmeno"];
        $_SESSION["email"] = $user["email"];
        header("Location:" . BASE_URL);
    }else{
        echo "password is wrong";
    }

} else if (!empty($_POST)) {
    echo "Username and password are required";
}
?>