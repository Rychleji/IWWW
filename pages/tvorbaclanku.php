<!-- Include Editor style. -->
<link href='https://cdn.jsdelivr.net/npm/froala-editor@2.9.1/css/froala_editor.min.css' rel='stylesheet' type='text/css' />
<link href='https://cdn.jsdelivr.net/npm/froala-editor@2.9.1/css/froala_style.min.css' rel='stylesheet' type='text/css' />

<!-- Include JS file. -->
<script type='text/javascript' src='https://cdn.jsdelivr.net/npm/froala-editor@2.9.1/js/froala_editor.min.js'></script>

<!-- Include external CSS. -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.25.0/codemirror.min.css">

<!-- Include Editor style. -->
<link href="https://cdn.jsdelivr.net/npm/froala-editor@2.9.1/css/froala_editor.pkgd.min.css" rel="stylesheet" type="text/css" />

<!-- Include external JS libs. -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.25.0/codemirror.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.25.0/mode/xml/xml.min.js"></script>

<!-- Include Editor JS files. -->
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/froala-editor@2.9.1/js/froala_editor.pkgd.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/froala-editor@2.9.1/js/plugins/image.min.js"></script>

<script type="text/javascript">
    function post(path, params, method) {
        method = method || "post"; // Set method to post by default if not specified.

        // The rest of this code assumes you are not using a library.
        // It can be made less wordy if you use one.
        var form = document.createElement("form");
        form.setAttribute("method", method);
        form.setAttribute("action", path);

        for(var key in params) {
            if(params.hasOwnProperty(key)) {
                var hiddenField = document.createElement("input");
                hiddenField.setAttribute("type", "hidden");
                hiddenField.setAttribute("name", key);
                hiddenField.setAttribute("value", params[key]);

                form.appendChild(hiddenField);
            }
        }

        document.body.appendChild(form);
        form.submit();
    }
</script>

<!-- Create a tag that we will use as the editable area. -->
<!-- You can use a div tag as well. -->
    <textfield id="froala-editor"></textfield>
    <div class="right">
        <button type="submit" id="get-text" class="btn" onclick="post('<?= BASE_URL . '?page=pridatclanek' ?>',
            {text: $('textfield#froala-editor').froalaEditor('html.get')})">Uložit</button>
    </div>

<!-- Initialize the editor. -->
<script>
    $(function() {
        $('textfield#froala-editor').froalaEditor({
            height: 500,

            // Set the image upload parameter.
            imageUploadParam: 'file',

            // Set the image upload URL.
            imageUploadURL: '/pages/imageupload.php',

            // Additional upload params.
            //imageUploadParams: {id: 'my_editor'},

            // Set request type.
            imageUploadMethod: 'POST',

            // Set max image size to 5MB.
            imageMaxSize: 5 * 1024 * 1024,

            // Allow to upload PNG and JPG.
            imageAllowedTypes: ['jpeg', 'jpg', 'png']
        })
            /*.on('froalaEditor.image.beforeUpload', function (e, editor, images) {
                // Return false if you want to stop the image upload.
            })
            .on('froalaEditor.image.uploaded', function (e, editor, response) {
                // Image was uploaded to the server.
            })
            .on('froalaEditor.image.inserted', function (e, editor, $img, response) {
                // Image was inserted in the editor.
            })
            .on('froalaEditor.image.replaced', function (e, editor, $img, response) {
                // Image was replaced in the editor.
            })*/
            .on('froalaEditor.image.error', function (e, editor, error, response) {
                // Bad link.
                if (error.code == 1) {
                    console.log('Bad link.');
                }

                // No link in upload response.
                else if (error.code == 2) {
                    console.log('No link in upload response.');
                }

                // Error during image upload.
                else if (error.code == 3) {
                    console.log('Error during image upload.');
                }

                // Parsing response failed.
                else if (error.code == 4) {
                    console.log('Parsing response failed.');
                }

                // Image too text-large.
                else if (error.code == 5) {
                    console.log('Image too text-large.');
                }

                // Invalid image type.
                else if (error.code == 6) {
                    console.log('Invalid image type.');
                }

                // Image can be uploaded only to same domain in IE 8 and IE 9.
                else if (error.code == 7) {
                    console.log('Image can be uploaded only to same domain in IE 8 and IE 9.');
                }
                console.log(response);

                // Response contains the original server response to the request if available.
            });
    });
</script>


<?php
if (!empty($_POST)) {
    //connect to database
    $conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt2 = $conn->prepare("select max(id_clanku)+1 as vysl from clanky");
    $stmt2->execute();
    $select = $stmt2->fetch();
    $idClanku = $select['vysl'];
    $stmt = $conn->prepare("INSERT INTO CLANKY(id_clanku, nazev, text_clanku, autor_uzivatelske_jmeno) 
        values (:id, :nazev, :text, :autor)");
    $stmt->bindParam(":id", $idClanku);
    $stmt->bindParam(':nazev', $_POST["nazevClanku"]);
    $stmt->bindParam(':text', $_POST["textClanku"]);
    $stmt->bindParam(':autor', $_SESSION["username"]);
    $stmt->execute();

    $tags = explode(";", $_POST["tagy"]);

    foreach ($tags as $tag) {
        $pTag = trim($tag);
        try {
            $stmt = $conn->prepare("INSERT INTO tagy values (:tag)");
            $stmt->bindParam(":tag", $pTag);
            $stmt->execute();
        } catch (Exception $e) { }

        $stmt = $conn->prepare("INSERT INTO clanky_has_tagy values (:idCl, :tag)");
        $stmt->bindParam(":idCl", $idClanku);
        $stmt->bindParam(":tag", $pTag);
        $stmt->execute();
    }
}
?>