<?php
session_start();
require_once("modelo.php");

$user = $password = "";

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

    $path2 = str_replace("thumb_", '', $path1); // remove carriage returns
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

if($_SERVER["REQUEST_METHOD"] == "POST") {
    unset($_SESSION["collectionId"]);
    if(isset($_POST["login"])) {
        $user = test_input($_POST["user"]);
        $password = test_input($_POST["password"]);
        if ($data = login($_POST["user"], $_POST["password"]) ) {
            unset($_SESSION["error"]);
            $_SESSION["user"] = $data["user"];
            $_SESSION["name"] = $data["name"];
            $name = $data["name"];
            header("location: index.php");
        } else {
            unset($_SESSION["user"]);
            $_SESSION["error"] = "Usuario y/o contraseña incorrectos";
            header("location: index.php");
        }
    } else if(isset($_POST["carousel"])) {
        if(isset($_SESSION["user"])) {
            foreach ($_FILES["pictures"]["error"] as $key => $error) {
                if ($error == UPLOAD_ERR_OK) {
                    $tmp_name = $_FILES["pictures"]["tmp_name"][$key];
                    // basename() may prevent filesystem traversal attacks;
                    // further validation/sanitation of the filename may be appropriate

                    $type = strtolower(pathinfo(basename($_FILES["pictures"]["name"][$key]),PATHINFO_EXTENSION));
                    $valid_type = array("jpg", "png", "jpeg", "gif");
                    if (in_array($type, $valid_type)) {
                        if (addCarouselImage(basename($_FILES["pictures"]["name"][$key]))) {
                            if (!is_dir("../carousel/") && !mkdir("../carousel")){
                                $_SESSION["error_upload"] = "Error creando la carpeta";
                            }
                            // save uploaded image
                            move_uploaded_file($tmp_name, "../carousel/".basename($_FILES["pictures"]["name"][$key]));
                            // reduce image size + save as std_
                            make_thumb("../carousel/".basename($_FILES["pictures"]["name"][$key]), "../carousel/std_".basename($_FILES["pictures"]["name"][$key]), 1080);
                            // destroy original (large) image
                            unlink("../carousel/".basename($_FILES["pictures"]["name"][$key]));
                            // remove _std
                            rename("../carousel/std_".basename($_FILES["pictures"]["name"][$key]), "../carousel/".basename($_FILES["pictures"]["name"][$key]));
                            // make a thumbnail
                            make_thumb("../carousel/".basename($_FILES["pictures"]["name"][$key]), "../carousel/thumb_".basename($_FILES["pictures"]["name"][$key]), 300);
                        } else {
                            $_SESSION["error_upload"] = "El archivo no fue cargado";
                        }
                    } else {
                        $_SESSION["error_upload"] = "El tipo de archivo no es valido";
                    }
                }
            }
            header("location: index.php");
        } else {
            $_SESSION["error"] = "Usuario y/o contraseña incorrectos";
            header("location: index.php");
        }
    } else if(isset($_POST["collection"])) {
        if(isset($_SESSION["user"])) {
            if(isset($_POST["name"]) && isset($_POST["description"])) {
                $name = test_input($_POST["name"]);
                $description = test_input($_POST["description"]);
                if($id = addCollection($name, $description)) {
                    $_SESSION["alert"] = "Colección creada de manera exitosa!";
                    header("location: upload_collection.php?collectionId={$id}");
                } else {
                    $_SESSION["error_delete"] = "La colección no se ha podido crear!";
                    header("location: index.php");
                }
            } else {
                $_SESSION["error_delete"] = "El nombre de la colección o su descripción no fueron recibidos!";
                header("location: index.php");
            }
        } else {
            $_SESSION["error"] = "Usuario y/o contraseña incorrectos";
            header("location: index.php");
        }
    } else if(isset($_POST["rotate"])) {
        if(isset($_SESSION["user"])) {
            $path = $_POST["rotate"];
            if(rotateImage($path)) {
                $_SESSION["alert"] = "Imagen rotada de manera exitosa!";
                header("location: index.php");
            } else {
                $_SESSION["error_delete"] = "La imagen no se ha podido rotar!";
                header("location: index.php");
            }
        } else {
            $_SESSION["error"] = "Usuario y/o contraseña incorrectos";
            header("location: index.php");
        }
    } else {
        $_SESSION["error"] = "Acción no valida";
        header("location: index.php");
    }
} else if(isset($_SESSION["user"]) ) {
    unset($_SESSION["error"]);
    $name = $_SESSION["name"];
    include("partials/_header.html");
    include("partials/_navbar.html");
    include("partials/_admin_view.html");
    include("partials/_footer.html");
    unset($_SESSION["error_upload"]);
    unset($_SESSION["error_delete"]);
    unset($_SESSION["alert"]);
    unset($_SESSION["collectionId"]);
} else {
    include("partials/_header.html");
    include("partials/_login_form.html");
    include("partials/_footer.html");
    unset($_SESSION["error"]);
    unset($_SESSION["error_upload"]);
    unset($_SESSION["error_delete"]);
    unset($_SESSION["alert"]);
    unset($_SESSION["collectionId"]);
}

?>
