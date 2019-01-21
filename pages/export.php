<?php
require_once "../config.php";

$conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if (isset($_GET['cl'])) {
    $stmt = $conn->prepare("SELECT * FROM clanky where id_clanku=:idClanku");
    $stmt->bindParam(':idClanku', $_GET['cl']);
}else{
    $stmt = $conn->prepare("SELECT * FROM clanky");
}

$stmt->execute();
$clanky=$stmt->fetchAll(PDO::FETCH_ASSOC);

//převzato z: https://stackoverflow.com/a/15982616/7462461
$x=new XMLWriter();
$x->openMemory();
$x->startDocument('1.0','UTF-8');
$x->startElement('clanky');

foreach ($clanky as $clanek) {

    $x->startElement('clanek');
    $x->writeAttribute('id_clanku',$clanek['id_clanku']);
    $x->writeAttribute('nazev',$clanek['nazev']);
    $x->writeAttribute('text',$clanek['text_clanku']);
    $x->writeAttribute('autor',$clanek['autor_uzivatelske_jmeno']);

    $x->endElement();
}

$x->endElement();
$x->endDocument();
$xml = $x->outputMemory();

file_put_contents("export.xml", $xml);

$file = 'export.xml';

if (file_exists($file)) {
    header("Content-Disposition: attachment; filename=" . basename($file) . "");
    header("Content-Length: " . filesize($file));
    header("Content-Type: application/octet-stream;");
    readfile($file);
    exit;
}

if (isset($_GET['cl'])) {
    header("Location:" . BASE_URL . "?page=clanek&clanek=" . $_GET['cl']);
}else{
    header("Location:" . BASE_URL . "?page=administrace");
}