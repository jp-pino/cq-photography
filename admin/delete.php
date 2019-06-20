<?php
session_start();
require_once("modelo.php");

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if(isset($_SESSION["user"])) {
    if(isset($_GET["imgId"]) && isset($_GET["collectionId"]) && isset($_GET["name"]) && isset($_GET["type"])) {
        $collection = test_input($_GET["collectionId"]);
        $name = test_input($_GET["name"]);
        $id = test_input($_GET["imgId"]);
        $type = test_input($_GET["type"]);
        if(unlink("../gallery/{$collection}/{$name}_{$id}.{$type}")) {
            if(unlink("../gallery/{$collection}/{$name}_{$id}_thumb.{$type}")) {
                unset($_SESSION["error_delete"]);
            } else {
                $_SESSION["error_delete"] = "La miniatura en \"../gallery/{$collection}/{$name}_{$id}_thumb.{$type}\" no se ha podido eliminar correctamente del sistema de archivos!";
            }
        } else {
            $_SESSION["error_delete"] = "La imagen en \"../gallery/{$collection}/{$name}_{$id}.{$type}\" no se ha podido eliminar correctamente del sistema de archivos!";
        }
        if(deleteImage($id)) {
            $_SESSION["alert"] = "Colección modificada de manera exitosa!";
        } else {
            $_SESSION["error_delete"] = "La imagen en \"../gallery/{$collection}/{$name}_{$id}.{$type}\" no se ha podido eliminar correctamente de la base de datos!";
        }
        header("location: upload_collection.php?collectionId={$collection}");
    } else if(isset($_GET["collectionId"])) {
        $collection = test_input($_GET["collectionId"]);
        array_map('unlink', glob("../gallery/{$collection}/*.*"));
        if(rmdir("../gallery/{$collection}/")) {
            unset($_SESSION["error_delete"]);
        } else {
            $_SESSION["error_delete"] = "La colección en \"../gallery/{$collection}\" no se ha podido eliminar correctamente del sistema de archivos!";
        }
        if(deleteCollection($collection)) {
            $_SESSION["alert"] = "Colección modificada de manera exitosa!";
        } else {
            $_SESSION["error_delete"] = "La colección en \"../gallery/{$collection}\" no se ha podido eliminar correctamente de la base de datos!";
        }
        header("location: index.php");
    } else if(isset($_GET["carouselId"])) {
        $carousel = test_input($_GET["carouselId"]);
        $name = getCarouselName($carousel);
        if(unlink("../carousel/{$name}")) {
            if(unlink("../carousel/thumb_{$name}")) {
                unset($_SESSION["error_delete"]);
            } else {
                $_SESSION["error_delete"] = "La imagen en \"../carousel/{$name}\" no se ha podido eliminar correctamente del sistema de archivos!";
            }
        } else {
            $_SESSION["error_delete"] = "La imagen en \"../carousel/{$name}\" no se ha podido eliminar correctamente del sistema de archivos!";
        }
        if(deleteCarousel($carousel)) {
            $_SESSION["alert"] = "Colección modificada de manera exitosa!";
        } else {
            $_SESSION["error_delete"] = "La imagen en \"../carousel/{$name}\" no se ha podido eliminar correctamente de la base de datos!";
        }
        header("location: index.php");
    }
} else {
    $_SESSION["error"] = "Usuario y/o contraseña incorrectos";
    header("location: index.php");
}

?>
