<?php
$conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>

<form method="post" enctype="multipart/form-data">
    Select XML to upload:
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Upload XML" name="submit">
</form>

<?php
if(isset($_POST["submit"])) {
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);

    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        //echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
    } else {
        //echo "Sorry, there was an error uploading your file.";
    }

    $xml = simplexml_load_file($target_file);

    foreach($xml->children() as $clanek)
    {
        /*echo "ID: ".$clanek->attributes()->id_clanku."<br />";
        echo "Název: ".$clanek->attributes()->nazev." <br />";
        echo "Text: ".$clanek->attributes()->text." <br />";
        echo "Autor: ".$clanek->attributes()->autor." <br />";
        echo "<hr/>";*/

        $stmt = $conn->prepare("INSERT INTO clanky values (:idCl, :nazev, :text, :autor)");

        $stmt->bindParam(':idCl', $clanek->attributes()->id_clanku);
        $stmt->bindParam(':nazev', $clanek->attributes()->nazev);
        $stmt->bindParam(':text', $clanek->attributes()->text);
        $stmt->bindParam(':autor', $clanek->attributes()->autor);
        try {
            $stmt->execute();
        }catch (Exception $e){}
    }
    header("Location:" . BASE_URL . "?page=administrace");
}

