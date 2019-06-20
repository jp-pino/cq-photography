<?php
session_start();
require_once("modelo.php");

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function rotateImage($path1) {
    // Load the image
    $source1 = imagecreatefromjpeg($path1);
    rename($path1, $path1.".old");

    $path2 = str_replace("_thumb", '', $path1); // remove carriage returns
    $source2 = imagecreatefromjpeg($path2);
    rename($path2, $path2.".old");
    // Rotate
    $rotate1 = imagerotate($source1, -90, 0);
    $rotate2 = imagerotate($source2, -90, 0);
    //and save it on your server...
    imagejpeg($rotate1, $path1, 100);
    imagejpeg($rotate2, $path2, 100);
    unlink($path1.".old");
    unlink($path2.".old");

    return true;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_SESSION["user"])) {
        if(isset($_POST["collection"])) {
            $_SESSION["collectionId"] = $_POST["collection"];
            if(isset($_POST["description"])) {
                foreach ($_FILES["pictures"]["error"] as $key => $error) {
                    if ($error == UPLOAD_ERR_OK) {
                        $tmp_name = $_FILES["pictures"]["tmp_name"][$key];
                        // basename() may prevent filesystem traversal attacks;
                        // further validation/sanitation of the filename may be appropriate

                        $name = pathinfo(basename($_FILES["pictures"]["name"][$key]),PATHINFO_FILENAME);
                        $type = strtolower(pathinfo(basename($_FILES["pictures"]["name"][$key]),PATHINFO_EXTENSION));
                        $collection = test_input($_POST["collection"]);

                        $valid_type = array("jpg", "png", "jpeg", "gif");
                        if (in_array($type, $valid_type)) {
                            if ($id = addImage($name, $type, $collection)) {
                                if (!is_dir("../gallery/{$collection}/") && !mkdir("../gallery/{$collection}/")){
                                    $_SESSION["error_upload"] = "Error creando la carpeta";
                                }
                                // save uploaded image
                                move_uploaded_file($tmp_name, "../gallery/{$collection}/{$name}_{$id}.{$type}");
                                // reduce image size + save as _std
                                make_thumb("../gallery/{$collection}/{$name}_{$id}.{$type}", "../gallery/{$collection}/{$name}_{$id}_std.{$type}", 1080);
                                // destroy original (large) image
                                unlink("../gallery/{$collection}/{$name}_{$id}.{$type}");
                                // remove _std
                                rename("../gallery/{$collection}/{$name}_{$id}_std.{$type}", "../gallery/{$collection}/{$name}_{$id}.{$type}");
                                // add watermark
                                // add_watermark("../images/logo_white.png", "../gallery/{$collection}/{$name}_{$id}.{$type}");
                                // make a thumbnail
                                make_thumb("../gallery/{$collection}/{$name}_{$id}.{$type}", "../gallery/{$collection}/{$name}_{$id}_thumb.{$type}", 300);
                            } else {
                                $_SESSION["error_upload"] = "El archivo no fue cargado";
                            }
                        } else {
                            $_SESSION["error_upload"] = "El tipo de archivo no es valido";
                        }
                    }
                }
                $_SESSION["alert"] = "Colección modificada de manera exitosa!";
                update_description($_POST["collection"], $_POST["description"]);
            } else {
                $_SESSION["error_upload"] = "Debes incluir una descripción para la colección!";
            }
            header("location: upload_collection.php");
        } else if(isset($_POST["rotate"])) {
            $path = $_POST["rotate"];
            if(rotateImage($path)) {
                $_SESSION["alert"] = "Imagen rotada de manera exitosa!";
                header("location: upload_collection.php");
            } else {
                $_SESSION["error_delete"] = "La imagen no se ha podido rotar!";
                header("location: upload_collection.php");
            }
        } else {
            $_SESSION["error_upload"] = "Colección no encontrada!";
            header("location: upload_collection.php");
        }
    } else {
        $_SESSION["error"] = "Usuario y/o contraseña incorrectos";
        header("location: index.php");
    }
} else if(isset($_SESSION["user"]) ) {
    if(isset($_GET["collectionId"])) {
        $_SESSION["collectionId"] = $_GET["collectionId"];
        $data = getCollection(test_input($_GET["collectionId"]));
        $collection = $data["name"];
        $collection_id = $data["id"];
        $description = $data["description"];
        $name = $_SESSION["name"];
    } else {
        $data = getCollection(1);
        if(isset($_SESSION["collectionId"])) {
            $data = getCollection($_SESSION["collectionId"]);
        }
        $collection = $data["name"];
        $collection_id = $data["id"];
        $description = $data["description"];
        $name = $_SESSION["name"];
    }
    include("partials/_header.html");
    include("partials/_navbar.html");
    include("partials/_collection_upload_form.html");
    include("partials/_footer.html");
    unset($_SESSION["error_upload"]);
    unset($_SESSION["error_delete"]);
    unset($_SESSION["alert"]);
} else {
    $_SESSION["error"] = "Usuario y/o contraseña incorrectos";
    header("location: index.php");
}


?>
