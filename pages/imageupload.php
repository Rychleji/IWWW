<?php

// Include the editor SDK.
require '../froalaSDK/lib/FroalaEditor.php';

// Store the image.
try {
    $response = FroalaEditor_Image::upload('/articleImages/');
    echo stripslashes(json_encode($response));
}
catch (Exception $e) {
    http_response_code(404);
}

?>