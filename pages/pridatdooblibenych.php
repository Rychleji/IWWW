<?php
$conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$stmt = $conn->prepare("insert into oblibene_clanky values(:uz, :cl)");
$stmt->bindParam(':uz', $_SESSION['username']);
$stmt->bindParam(':cl', $_GET['c']);
$stmt->execute();

header("Location:" . BASE_URL . "?page=clanek&clanek=".$_GET['c']);