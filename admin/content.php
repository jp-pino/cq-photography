<?php
session_start();
require_once("modelo.php");

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_SESSION["user"])) {
        if(isset($_POST["add-quote"])) {
            if(isset($_POST["content"]) && isset($_POST["name"])) {
                if (addQuote(test_input($_POST["content"]),test_input($_POST["name"]))) {
                    $_SESSION["alert"] = "Referencia agregada exitosamente!";
                    unset($_SESSION["error"]);
                    header("location: content.php");
                } else {
                    $_SESSION["error"] = "Error al registrar referencia en base de datos";
                    header("location: content.php");
                }
            } else {
                $_SESSION["error"] = "Error al agregar referencia";
                header("location: content.php");
            }
        } else if(isset($_POST["update-quote"])) {
            if(isset($_POST["content"]) && isset($_POST["author"]) && isset($_POST["quoteId"])) {
                $content = nl2br(test_input($_POST["content"]));
                $content = str_replace("\t", '', $content); // remove tabs
                $content = str_replace("\n", '', $content); // remove new lines
                $content = str_replace("\r", '', $content); // remove carriage returns
                if (updateQuote($content,test_input($_POST["author"]),test_input($_POST["quoteId"]))) {
                    $_SESSION["alert"] = "Referencia actualizada exitosamente!";
                    unset($_SESSION["error"]);
                    header("location: content.php");
                } else {
                    $_SESSION["error"] = "Error al actualizar referencia en base de datos";
                    header("location: content.php");
                }
            } else {
                $_SESSION["error"] = "Error al agregar referencia";
                header("location: content.php");
            }
        } else if(isset($_POST["delete-quote"])) {
            if(isset($_POST["quoteId"])) {
                if (deleteQuote(test_input($_POST["quoteId"]))) {
                    $_SESSION["alert"] = "Referencia eliminada exitosamente!";
                    unset($_SESSION["error"]);
                    header("location: content.php");
                } else {
                    $_SESSION["error"] = "Error al eliminar referencia de base de datos";
                    header("location: content.php");
                }
            } else {
                $_SESSION["error"] = "Error al eliminar referencia";
                header("location: content.php");
            }
        } else if(isset($_POST["edit-image"])) {
            foreach ($_FILES["pictures"]["error"] as $key => $error) {
                if ($error == UPLOAD_ERR_OK) {
                    $tmp_name = $_FILES["pictures"]["tmp_name"][$key];
                    // basename() may prevent filesystem traversal attacks;
                    // further validation/sanitation of the filename may be appropriate

                    $type = strtolower(pathinfo(basename($_FILES["pictures"]["name"][$key]),PATHINFO_EXTENSION));
                    $valid_type = array("jpg", "png", "jpeg", "gif");
                    if (in_array($type, $valid_type)) {
                        unlink(getContentImage());
                        if (updateContentImage(basename($_FILES["pictures"]["name"][$key]))) {
                            if (!is_dir("../content/") && !mkdir("../content")){
                                $_SESSION["error_upload"] = "Error creando la carpeta";
                            }
                            // save uploaded image
                            move_uploaded_file($tmp_name, "../content/".basename($_FILES["pictures"]["name"][$key]));
                            // reduce image size + save as std_
                            make_thumb("../content/".basename($_FILES["pictures"]["name"][$key]), "../content/std_".basename($_FILES["pictures"]["name"][$key]), 1080);
                            // destroy original (large) image
                            unlink("../content/".basename($_FILES["pictures"]["name"][$key]));
                            // remove _std
                            rename("../content/std_".basename($_FILES["pictures"]["name"][$key]), "../content/".basename($_FILES["pictures"]["name"][$key]));
                        } else {
                            $_SESSION["error_upload"] = "El archivo no fue cargado";
                        }
                    } else {
                        $_SESSION["error_upload"] = "El tipo de archivo no es valido";
                    }
                }
            }
            header("location: content.php");
        } else if(isset($_POST["edit-back-image"])) {
            foreach ($_FILES["pictures"]["error"] as $key => $error) {
                if ($error == UPLOAD_ERR_OK) {
                    $tmp_name = $_FILES["pictures"]["tmp_name"][$key];
                    // basename() may prevent filesystem traversal attacks;
                    // further validation/sanitation of the filename may be appropriate

                    $type = strtolower(pathinfo(basename($_FILES["pictures"]["name"][$key]),PATHINFO_EXTENSION));
                    $valid_type = array("jpg", "png", "jpeg", "gif");
                    if (in_array($type, $valid_type)) {
                        unlink(getBackgroundImage());
                        if (updateBackgroundImage(basename($_FILES["pictures"]["name"][$key]))) {
                            if (!is_dir("../content/") && !mkdir("../content")){
                                $_SESSION["error_upload"] = "Error creando la carpeta";
                            }
                            // save uploaded image
                            move_uploaded_file($tmp_name, "../content/".basename($_FILES["pictures"]["name"][$key]));
                            // reduce image size + save as std_
                            make_thumb("../content/".basename($_FILES["pictures"]["name"][$key]), "../content/std_".basename($_FILES["pictures"]["name"][$key]), 1080);
                            // destroy original (large) image
                            unlink("../content/".basename($_FILES["pictures"]["name"][$key]));
                            // remove _std
                            rename("../content/std_".basename($_FILES["pictures"]["name"][$key]), "../content/".basename($_FILES["pictures"]["name"][$key]));
                        } else {
                            $_SESSION["error_upload"] = "El archivo no fue cargado";
                        }
                    } else {
                        $_SESSION["error_upload"] = "El tipo de archivo no es valido";
                    }
                }
            }
            header("location: content.php");
        } else if(isset($_POST["description"])) {
            if(isset($_POST["bio"])) {
                $bio = nl2br(test_input($_POST["bio"]));
                $bio = str_replace("\t", '', $bio); // remove tabs
                $bio = str_replace("\n", '', $bio); // remove new lines
                $bio = str_replace("\r", '', $bio); // remove carriage returns
                if (updateBio($bio)) {
                    $_SESSION["alert"] = "Biografía actualizada exitosamente!";
                    unset($_SESSION["error"]);
                    header("location: content.php");
                } else {
                    $_SESSION["error"] = "Error al actualizar referencia en base de datos";
                    header("location: content.php");
                }
            } else {
                $_SESSION["error"] = "Error al agregar referencia";
                header("location: content.php");
            }
        } else {
            $_SESSION["error"] = "Acción no valida";
            header("location: content.php");
        }
    } else {
        header("location: index.php");
    }
} else if(isset($_SESSION["user"]) ) {
    unset($_SESSION["error"]);
    $name = $_SESSION["name"];
    include("partials/_header.html");
    include("partials/_navbar.html");
    include("partials/_content_editor.html");
    include("partials/_footer.html");
    unset($_SESSION["alert"]);
} else {
    header("location: index.php");
}


?>
