<?php
function connect() {
    $mysql = mysqli_connect("localhost","id5310764_user","KVY-SWp-MDZ-d3n","id5310764_quintanilla");
    $mysql->set_charset("utf8");
    return $mysql;
}

function disconnect($mysql) {
    mysqli_close($mysql);
}

function login($user, $password) {
    $db = connect();
    if ($db != NULL) {
        // insert command specification
        $query="SELECT * FROM users WHERE user = ? AND password = ?";
        // Preparing the statement
        if (!($statement = $db->prepare($query))) {
            die("Preparation failed: (" . $db->errno . ") " . $db->error);
        }
        // Binding statement params
        if (!$statement->bind_param("ss", $user, $password)) {
            die("Parameter vinculation failed: (" . $statement->errno . ") " . $statement->error);
        }
        // Executing the statement
        if (!$statement->execute()) {
            die("Execution failed: (" . $statement->errno . ") " . $statement->error);
        }
        // Get results
        $results = $statement->get_result();

        if (mysqli_num_rows($results) > 0)  {
            // it releases the associated results
            $data = mysqli_fetch_array($results, MYSQLI_BOTH);
            mysqli_free_result($results);
            disconnect($db);
            return $data;
        }
        disconnect($db);
        return false;
    }
    return false;
}

function signup($id) {
    $db = connect();
    if ($db != NULL) {

        // insert command specification
        $query='INSERT INTO Usuarios (id) VALUES (?) ';
        // Preparing the statement
        if (!($statement = $db->prepare($query))) {
            die("Preparation failed: (" . $db->errno . ") " . $db->error);
        }
        // Binding statement params
        if (!$statement->bind_param("s", $id)) {
            die("Parameter vinculation failed: (" . $statement->errno . ") " . $statement->error);
        }
         // Executing the statement
        if (!$statement->execute()) {
            die("Execution failed: (" . $statement->errno . ") " . $statement->error);
        }

        disconnect($db);
        return $id;
    }
    return false;
}

//var_dump(login('lalo', 'hockey'));
//var_dump(login('joaquin', 'basket'));
//var_dump(login('cesar', 'basket'));

function addImage($name, $type, $collection) {
    $db = connect();
    if ($db != NULL) {

        // insert command specification
        $query='INSERT INTO image (name, type) VALUES (?,?) ';
        // Preparing the statement
        if (!($statement = $db->prepare($query))) {
            die("Preparation failed: (" . $db->errno . ") " . $db->error);
        }
        // Binding statement params
        if (!$statement->bind_param("ss", $name, $type)) {
            die("Parameter vinculation failed: (" . $statement->errno . ") " . $statement->error);
        }
         // Executing the statement
        if (!$statement->execute()) {
            die("Execution failed: (" . $statement->errno . ") " . $statement->error);
        }

        $last_id = $db->insert_id;
        disconnect($db);

        $db = connect();
        if ($db != NULL) {

            // insert command specification
            $query='INSERT INTO image_collection (id_collection, id_image) VALUES (?,?) ';
            // Preparing the statement
            if (!($statement = $db->prepare($query))) {
                die("Preparation failed: (" . $db->errno . ") " . $db->error);
            }
            // Binding statement params
            if (!$statement->bind_param("ii", $collection, $last_id)) {
                die("Parameter vinculation failed: (" . $statement->errno . ") " . $statement->error);
            }
             // Executing the statement
            if (!$statement->execute()) {
                die("Execution failed: (" . $statement->errno . ") " . $statement->error);
            }

            disconnect($db);
            return $last_id;
        }
        return false;
    }
    return false;
}

function addCarouselImage($name) {
    $db = connect();
    if ($db != NULL) {

        // insert command specification
        $query='INSERT INTO carousel (name) VALUES (?) ';
        // Preparing the statement
        if (!($statement = $db->prepare($query))) {
            die("Preparation failed: (" . $db->errno . ") " . $db->error);
        }
        // Binding statement params
        if (!$statement->bind_param("s", $name)) {
            die("Parameter vinculation failed: (" . $statement->errno . ") " . $statement->error);
        }
         // Executing the statement
        if (!$statement->execute()) {
            die("Execution failed: (" . $statement->errno . ") " . $statement->error);
        }

        disconnect($db);
        return true;
    }
    return false;
}

function getCarousel($address) {
    $db = connect();
    if ($db != NULL) {

        //Specification of the SQL query
        $query="SELECT id, name, cast(C.date as date) as 'date' FROM carousel C";
        // Query execution; returns identifier of the result group
        $results = $db->query($query);
         // cycle to explode every line of the results
        $html = '';
        while ($fila = mysqli_fetch_array($results, MYSQLI_BOTH)) {
            // Options: MYSQLI_NUM to use only numeric indexes
            // MYSQLI_ASSOC to use only name (string) indexes
            // MYSQLI_BOTH, to use both
            $html .=   "<div class=\"card mb-3\">
                            <div class=\"card-btn-group\">
                                <form action=\"{$address}\" method=\"POST\">
                                    <button type=\"submit\" class=\"btn btn-primary\" name=\"rotate\" value=\"../carousel/thumb_".$fila["name"]."\"><i class=\"fas fa-redo-alt\"></i></button>
                                    <a href=\"delete.php?carouselId=".$fila["id"]."\" class=\"card-btn btn btn-danger ml-auto\"><i class=\"fas fa-trash-alt\"></i></a>
                                </form>
                            </div>
                            <img class=\"card-img-top\" src=\"../carousel/thumb_".$fila["name"]."?".rand(1,32000)."\" alt=\"Card image cap\">
                            <div class=\"card-body\">
                                <span class=\"text-muted mr-auto\">Cargada el día ".$fila["date"]."</span>
                            </div>
                        </div>";
        }
        echo $html;
        // it releases the associated results
        mysqli_free_result($results);
        disconnect($db);
        return true;
    }
    return true;
}

function getCarouselName($id) {
    $db = connect();
    if ($db != NULL) {
        // insert command specification
        $query="SELECT name FROM carousel WHERE id = ?";
        // Preparing the statement
        if (!($statement = $db->prepare($query))) {
            die("Preparation failed: (" . $db->errno . ") " . $db->error);
        }
        // Binding statement params
        if (!$statement->bind_param("i", $id)) {
            die("Parameter vinculation failed: (" . $statement->errno . ") " . $statement->error);
        }
        // Executing the statement
        if (!$statement->execute()) {
            die("Execution failed: (" . $statement->errno . ") " . $statement->error);
        }
        // Get results
        $results = $statement->get_result();

        if (mysqli_num_rows($results) > 0)  {
            // it releases the associated results
            $data = mysqli_fetch_array($results, MYSQLI_BOTH);
            mysqli_free_result($results);
            disconnect($db);
            return $data["name"];
        }
        disconnect($db);
        return false;
    }
    return false;
}

function addCollection($name, $description) {
    $db = connect();
    if ($db != NULL) {

        // insert command specification
        $query='INSERT INTO collection (name, description) VALUES (?,?) ';
        // Preparing the statement
        if (!($statement = $db->prepare($query))) {
            die("Preparation failed: (" . $db->errno . ") " . $db->error);
        }
        // Binding statement params
        if (!$statement->bind_param("ss", $name, $description)) {
            die("Parameter vinculation failed: (" . $statement->errno . ") " . $statement->error);
        }
         // Executing the statement
        if (!$statement->execute()) {
            die("Execution failed: (" . $statement->errno . ") " . $statement->error);
        }

        $last_id = $db->insert_id;

        disconnect($db);
        return $last_id;
    }
    return false;
}

function deleteImage($id) {
    $db = connect();
    if ($db != NULL) {
        // insert command specification
        $query="DELETE FROM image WHERE id = ?";
        // Preparing the statement
        if (!($statement = $db->prepare($query))) {
            die("Preparation failed: (" . $db->errno . ") " . $db->error);
        }
        // Binding statement params
        if (!$statement->bind_param("i", $id)) {
            die("Parameter vinculation failed: (" . $statement->errno . ") " . $statement->error);
        }
         // Executing the statement
        if (!$statement->execute()) {
            die("Execution failed: (" . $statement->errno . ") " . $statement->error);
        }
        disconnect($db);
        return true;
    }
    return false;
}

function deleteCarousel($id) {
    $db = connect();
    if ($db != NULL) {
        // insert command specification
        $query="DELETE FROM carousel WHERE id = ?";
        // Preparing the statement
        if (!($statement = $db->prepare($query))) {
            die("Preparation failed: (" . $db->errno . ") " . $db->error);
        }
        // Binding statement params
        if (!$statement->bind_param("i", $id)) {
            die("Parameter vinculation failed: (" . $statement->errno . ") " . $statement->error);
        }
         // Executing the statement
        if (!$statement->execute()) {
            die("Execution failed: (" . $statement->errno . ") " . $statement->error);
        }
        disconnect($db);
        return true;
    }
    return false;
}

function deleteCollection($id) {
    $db = connect();
    if ($db != NULL) {
        // insert command specification
        $query="DELETE FROM collection WHERE id = ?";
        // Preparing the statement
        if (!($statement = $db->prepare($query))) {
            die("Preparation failed: (" . $db->errno . ") " . $db->error);
        }
        // Binding statement params
        if (!$statement->bind_param("i", $id)) {
            die("Parameter vinculation failed: (" . $statement->errno . ") " . $statement->error);
        }
         // Executing the statement
        if (!$statement->execute()) {
            die("Execution failed: (" . $statement->errno . ") " . $statement->error);
        }
        disconnect($db);
        return true;
    }
    return false;
}

function make_thumb($file, $dest, $width) {
    // file - original image
    // dest - target destination for thumbnail
    // width - thumbnail width (height calculated)

    $what = getimagesize($file);
    //    echo $what["width"] . $what["height"];
    switch (strtolower($what['mime'])) {
        case 'image/png':
            $img = imagecreatefrompng($file);

            break;
        case 'image/jpeg':
            $img = imagecreatefromjpeg($file);

            break;
        case 'image/gif':
            $img = imagecreatefromgif($file);
            break;
        default:
            die();
    }
    $new = imagecreatetruecolor($width, $width*$what[1]/$what[0]);
    imagecopyresampled($new, $img, 0, 0, 0, 0, $width, $width*$what[1]/$what[0], $what[0], $what[1]);
    imagejpeg($new, $dest, 100);
    imagedestroy($new);
    return true;
}

// function add_watermark($logo, $file) {
//     // Load the stamp and the photo to apply the watermark to
//     $stamp = imagecreatefrompng($logo);
//     $what = getimagesize($file);
//     //    echo $what["width"] . $what["height"];
//     switch (strtolower($what['mime'])) {
//         case 'image/png':
//             $im = imagecreatefrompng($file);
//             break;
//         case 'image/jpeg':
//             $im = imagecreatefromjpeg($file);
//             break;
//         case 'image/gif':
//             $im = imagecreatefromgif($file);
//             break;
//         default:
//             die();
//     }
//
//     // Set the margins for the stamp and get the height/width of the stamp image
//     $marge_right = 10;
//     $marge_bottom = 10;
//     $sx = 50;
//     $sy = 50*imagesy($stamp)/imagesx($stamp);
//
//     // Copy the stamp image onto our photo using the margin offsets and the photo
//     // width to calculate positioning of the stamp.
//     imagecopy($im, $stamp, imagesx($im) - $sx - $marge_right, imagesy($im) - $sy - $marge_bottom, 0, 0, imagesx($stamp), imagesy($stamp));
//
//     // Output and free memory
//     // header('Content-type: image/png');
//     switch (strtolower($what['mime'])) {
//         case 'image/png':
//             imagepng($im);
//             break;
//         case 'image/jpeg':
//         case 'image/jpg'
//             imagejpeg($im);
//             break;
//         case 'image/gif':
//             imagegif($im);
//             break;
//         default:
//             die();
//     }
//     rename($file, $file.".old");
//     rename($im, $file);
//     unlink($file.".old");
//     return true;
// }

function getCollections() {
    $db = connect();
    if ($db != NULL) {

        //Specification of the SQL query
        $query="SELECT C.id, C.name as 'name', I.name as 'img_name', MIN(id_image) as 'cover', type, description, cast(C.date as date) as 'date_cast'
                FROM collection C, image_collection IC, image I WHERE C.id = IC.id_collection AND IC.id_image = I.id GROUP BY C.id";

        // Query execution; returns identifier of the result group
        $results = $db->query($query);
         // cycle to explode every line of the results
        $html = '';
        while ($fila = mysqli_fetch_array($results, MYSQLI_BOTH)) {
            // Options: MYSQLI_NUM to use only numeric indexes
            // MYSQLI_ASSOC to use only name (string) indexes
            // MYSQLI_BOTH, to use both
            $html .=   "<div class=\"card mb-3\">
                            <div class=\"card-btn-group\">
                                <a href=\"upload_collection.php?collectionId=".$fila["id"]."\" class=\"card-btn btn btn-primary ml-auto\"><i class=\"fas fa-pencil-alt\"></i></a>
                                <a href=\"delete.php?collectionId=".$fila["id"]."\" class=\"card-btn btn btn-danger ml-auto\"><i class=\"fas fa-trash-alt\"></i></a>
                            </div>
                            <img class=\"card-img-top\" src=\"../gallery/".$fila["id"]."/".$fila["img_name"]."_".$fila["cover"]."_thumb.".$fila["type"]."?".rand(1,32000)."\" alt=\"Image\">
                            <div class=\"card-body\">
                                <h5 class=\"card-title\">".$fila["name"]."</h5>
                                <p class=\"card-text\">".$fila["description"]."</p>
                                <p class=\"card-text text-muted mr-auto\">Creada el día ".$fila["date_cast"]."</p>
                            </div>
                        </div>";
        }
        echo $html;
        // it releases the associated results
        mysqli_free_result($results);
        disconnect($db);
        return true;
    }
    return true;
}

function getQuotes($address) {
    $db = connect();
    if ($db != NULL) {

        //Specification of the SQL query
        $query="SELECT id, quote, author, cast('date' as date) as 'date_cast' FROM quotes";

        // Query execution; returns identifier of the result group
        $results = $db->query($query);
         // cycle to explode every line of the results
        $html = '';
        while ($fila = mysqli_fetch_array($results, MYSQLI_BOTH)) {
            // Options: MYSQLI_NUM to use only numeric indexes
            // MYSQLI_ASSOC to use only name (string) indexes
            // MYSQLI_BOTH, to use both
            $id = $fila["id"];
            $quote = $fila["quote"];
            $breaks = array("<br />","<br>","<br/>");
            $quote = str_ireplace($breaks, "\r\n", $quote);
            $author = $fila["author"];
            $date = $fila["date_cast"];
            $html .=   "<div class=\"row\">
                            <div class=\"card mb-3 w-100\">
                                <div class=\"card-header d-flex\">Referencia<span class=\"text-muted ml-auto\">{$date}</span></div>
                                <div class=\"card-body pb-5\">
                                    <form action=\"{$address}\" method=\"POST\">
                                        <input name=\"quoteId\" type=\"hidden\" value=\"{$id}\">
                                        <div class=\"form-group\">
                                            <label for=\"content\">Contenido</label>
                                            <textarea class=\"form-control\" id=\"content\" name=\"content\" rows=\"3\" required>{$quote}</textarea>
                                        </div>
                                        <div class=\"form-group\">
                                            <label for=\"author\">Autor</label>
                                            <input name=\"author\" type=\"text\" class=\"form-control\" aria-describedby=\"quoteAuthor\" placeholder=\"Nombre del autor de...\" value=\"{$author}\" required>
                                        </div>
                                        <div class=\"card-btn-group-b\">
                                            <button type=\"submit\" class=\"btn btn-danger\" name=\"delete-quote\" value=\"Registrar\"><i class=\"fas fa-trash-alt\"></i></button>
                                            <input type=\"submit\" class=\"btn btn-primary\" name=\"update-quote\" value=\"Registrar\">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>";
        }
        echo $html;
        // it releases the associated results
        mysqli_free_result($results);
        disconnect($db);
        return true;
    }
    return true;
}

function getCollection($id) {
    $db = connect();
    if ($db != NULL) {
        // insert command specification
        $query="SELECT * FROM collection WHERE id = ?";
        // Preparing the statement
        if (!($statement = $db->prepare($query))) {
            die("Preparation failed: (" . $db->errno . ") " . $db->error);
        }
        // Binding statement params
        if (!$statement->bind_param("i", $id)) {
            die("Parameter vinculation failed: (" . $statement->errno . ") " . $statement->error);
        }
        // Executing the statement
        if (!$statement->execute()) {
            die("Execution failed: (" . $statement->errno . ") " . $statement->error);
        }
        // Get results
        $results = $statement->get_result();

        if (mysqli_num_rows($results) > 0)  {
            // it releases the associated results
            $data = mysqli_fetch_array($results, MYSQLI_BOTH);
            mysqli_free_result($results);
            disconnect($db);
            return $data;
        }
        disconnect($db);
        return false;
    }
    return false;
}

function getImages($collection_id, $address) {
    $db = connect();
    if ($db != NULL) {
        // insert command specification
        $query="SELECT IC.id_image, IC.id_collection, I.name, type FROM image_collection IC, image I WHERE IC.id_image = I.id AND id_collection = ? ORDER BY IC.id_image ASC";
        // Preparing the statement
        if (!($statement = $db->prepare($query))) {
            die("Preparation failed: (" . $db->errno . ") " . $db->error);
        }
        // Binding statement params
        if (!$statement->bind_param("i", $collection_id)) {
            die("Parameter vinculation failed: (" . $statement->errno . ") " . $statement->error);
        }
        // Executing the statement
        if (!$statement->execute()) {
            die("Execution failed: (" . $statement->errno . ") " . $statement->error);
        }
        // Get results
        $results = $statement->get_result();

        $html = "<div class=\"card-columns\">";
        $i = 1;
        while ($fila = mysqli_fetch_array($results, MYSQLI_BOTH)) {
            // Options: MYSQLI_NUM to use only numeric indexes
            // MYSQLI_ASSOC to use only name (string) indexes
            // MYSQLI_BOTH, to use both
            $html .=   "<div class=\"card text-white\">
                            <img class=\"card-img\" src=\"../gallery/".$fila["id_collection"]."/".$fila["name"]."_".$fila["id_image"]."_thumb.".$fila["type"]."?".rand(1,32000)."\" alt=\"Card image\">
                            <div class=\"card-img-overlay\">
                                <h5 class=\"card-title text-shadow\">".$fila["name"].".".$fila["type"]."</h5>
                                <div class=\"card-btn-group-b\">
                                    <form action=\"{$address}\" method=\"POST\">
                                        <button type=\"submit\" class=\"btn btn-primary\" name=\"rotate\" value=\"../gallery/".$fila["id_collection"]."/".$fila["name"]."_".$fila["id_image"]."_thumb.".$fila["type"]."\"><i class=\"fas fa-redo-alt\"></i></button>
                                        <a href=\"delete.php?imgId=".$fila["id_image"]."&collectionId=".$fila["id_collection"]."&name=".$fila["name"]."&type=".$fila["type"]."\" class=\"card-btn btn btn-danger ml-auto\"><i class=\"fas fa-trash-alt\"></i></a>
                                    </form>
                                </div>
                            </div>
                        </div>";
        }
        echo $html."</div>";
        // it releases the associated results
        mysqli_free_result($results);
        disconnect($db);
        return true;
    }
    return false;
}

function update_description($collection_id, $description) {
    $db = connect();
    if ($db != NULL) {

        // insert command specification
        $query='UPDATE collection SET description = ? WHERE id = ?';
        // Preparing the statement
        if (!($statement = $db->prepare($query))) {
            die("Preparation failed: (" . $db->errno . ") " . $db->error);
        }
        // Binding statement params
        if (!$statement->bind_param("si", $description, $collection_id)) {
            die("Parameter vinculation failed: (" . $statement->errno . ") " . $statement->error);
        }
         // Executing the statement
        if (!$statement->execute()) {
            die("Execution failed: (" . $statement->errno . ") " . $statement->error);
        }

        disconnect($db);
        return true;
    }
    return false;
}

function updateBio($text) {
    $db = connect();
    if ($db != NULL) {

        // insert command specification
        $query="UPDATE content SET text = ? WHERE section = 'bio'";
        // Preparing the statement
        if (!($statement = $db->prepare($query))) {
            die("Preparation failed: (" . $db->errno . ") " . $db->error);
        }
        // Binding statement params
        if (!$statement->bind_param("s", $text)) {
            die("Parameter vinculation failed: (" . $statement->errno . ") " . $statement->error);
        }
         // Executing the statement
        if (!$statement->execute()) {
            die("Execution failed: (" . $statement->errno . ") " . $statement->error);
        }

        disconnect($db);
        return true;
    }
    return false;
}

function getBio() {
    $db = connect();
    if ($db != NULL) {
        // insert command specification
        $query="SELECT text FROM content WHERE section = 'bio'";
        // Preparing the statement
        $results = $db->query($query);

        if ($fila = mysqli_fetch_array($results, MYSQLI_BOTH)) {
            // Options: MYSQLI_NUM to use only numeric indexes
            // MYSQLI_ASSOC to use only name (string) indexes
            // MYSQLI_BOTH, to use both
            // it releases the associated results

            $bio = $fila["text"];
            $breaks = array("<br />","<br>","<br/>");
            $bio = str_ireplace($breaks, "\r\n", $bio);
            mysqli_free_result($results);
            disconnect($db);
            return $bio;
        }
        // it releases the associated results
        mysqli_free_result($results);
        disconnect($db);
        return false;
    }
    return false;
}

function getContentImage() {
    $db = connect();
    if ($db != NULL) {
        // insert command specification
        $query="SELECT * FROM content WHERE section = 'image'";
        // Preparing the statement
        $results = $db->query($query);

        if ($fila = mysqli_fetch_array($results, MYSQLI_BOTH)) {
            // Options: MYSQLI_NUM to use only numeric indexes
            // MYSQLI_ASSOC to use only name (string) indexes
            // MYSQLI_BOTH, to use both
            // it releases the associated results
            mysqli_free_result($results);
            disconnect($db);
            return "../content/".$fila["text"];
        }
        // it releases the associated results
        mysqli_free_result($results);
        disconnect($db);
        return "../images/add-icon.png";
    }
    return "../images/add-icon.png";
}

function updateContentImage($image) {
    $db = connect();
    if ($db != NULL) {

        // insert command specification
        $query="UPDATE content SET text = ? WHERE section = 'image'";
        // Preparing the statement
        if (!($statement = $db->prepare($query))) {
            die("Preparation failed: (" . $db->errno . ") " . $db->error);
        }
        // Binding statement params
        if (!$statement->bind_param("s", $image)) {
            die("Parameter vinculation failed: (" . $statement->errno . ") " . $statement->error);
        }
         // Executing the statement
        if (!$statement->execute()) {
            die("Execution failed: (" . $statement->errno . ") " . $statement->error);
        }
        disconnect($db);
        return true;
    }
    return false;
}

function updateQuote($content, $name, $id) {
    $db = connect();
    if ($db != NULL) {

        // insert command specification
        $query="UPDATE quotes SET quote = ?, author = ? WHERE id = ?";
        // Preparing the statement
        if (!($statement = $db->prepare($query))) {
            die("Preparation failed: (" . $db->errno . ") " . $db->error);
        }
        // Binding statement params
        if (!$statement->bind_param("ssi", $content, $name, $id)) {
            die("Parameter vinculation failed: (" . $statement->errno . ") " . $statement->error);
        }
         // Executing the statement
        if (!$statement->execute()) {
            die("Execution failed: (" . $statement->errno . ") " . $statement->error);
        }
        disconnect($db);
        return true;
    }
    return false;
}

function addQuote($content, $author) {
    $db = connect();
    if ($db != NULL) {

        // insert command specification
        $query='INSERT INTO quotes (quote, author) VALUES (?,?) ';
        // Preparing the statement
        if (!($statement = $db->prepare($query))) {
            die("Preparation failed: (" . $db->errno . ") " . $db->error);
        }
        // Binding statement params
        if (!$statement->bind_param("ss", $content, $author)) {
            die("Parameter vinculation failed: (" . $statement->errno . ") " . $statement->error);
        }
         // Executing the statement
        if (!$statement->execute()) {
            die("Execution failed: (" . $statement->errno . ") " . $statement->error);
        }

        disconnect($db);
        return true;
    }
    return false;
}

function deleteQuote($id) {
    $db = connect();
    if ($db != NULL) {

        // insert command specification
        $query='DELETE FROM quotes WHERE id = ?';
        // Preparing the statement
        if (!($statement = $db->prepare($query))) {
            die("Preparation failed: (" . $db->errno . ") " . $db->error);
        }
        // Binding statement params
        if (!$statement->bind_param("i", $id)) {
            die("Parameter vinculation failed: (" . $statement->errno . ") " . $statement->error);
        }
         // Executing the statement
        if (!$statement->execute()) {
            die("Execution failed: (" . $statement->errno . ") " . $statement->error);
        }

        disconnect($db);
        return true;
    }
    return false;
}

function getBackgroundImage() {
    $db = connect();
    if ($db != NULL) {
        // insert command specification
        $query="SELECT * FROM content WHERE section = 'back_image'";
        // Preparing the statement
        $results = $db->query($query);

        if ($fila = mysqli_fetch_array($results, MYSQLI_BOTH)) {
            // Options: MYSQLI_NUM to use only numeric indexes
            // MYSQLI_ASSOC to use only name (string) indexes
            // MYSQLI_BOTH, to use both
            // it releases the associated results
            mysqli_free_result($results);
            disconnect($db);
            return "../content/".$fila["text"];
        }
        // it releases the associated results
        mysqli_free_result($results);
        disconnect($db);
        return "../images/add-icon.png";
    }
    return "../images/add-icon.png";
}

function updateBackgroundImage($image) {
    $db = connect();
    if ($db != NULL) {

        // insert command specification
        $query="UPDATE content SET text = ? WHERE section = 'back_image'";
        // Preparing the statement
        if (!($statement = $db->prepare($query))) {
            die("Preparation failed: (" . $db->errno . ") " . $db->error);
        }
        // Binding statement params
        if (!$statement->bind_param("s", $image)) {
            die("Parameter vinculation failed: (" . $statement->errno . ") " . $statement->error);
        }
         // Executing the statement
        if (!$statement->execute()) {
            die("Execution failed: (" . $statement->errno . ") " . $statement->error);
        }
        disconnect($db);
        return true;
    }
    return false;
}

?>
