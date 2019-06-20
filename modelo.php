<?php
function connect() {
    $mysql = mysqli_connect("localhost","id5310764_user","KVY-SWp-MDZ-d3n","id5310764_quintanilla");
    $mysql->set_charset("utf8");
    return $mysql;
}

function disconnect($mysql) {
    mysqli_close($mysql);
}

function getCarousel() {
    $db = connect();
    if ($db != NULL) {

        //Specification of the SQL query
        $query="SELECT name FROM carousel C";
        // Query execution; returns identifier of the result group
        $results = $db->query($query);
         // cycle to explode every line of the results
        $html = '';
        while ($fila = mysqli_fetch_array($results, MYSQLI_BOTH)) {
            // Options: MYSQLI_NUM to use only numeric indexes
            // MYSQLI_ASSOC to use only name (string) indexes
            // MYSQLI_BOTH, to use both
            $name = $fila["name"];
            $html .= "<div class=\"carousel-item\" style=\"background-image: url('carousel/{$name}?".rand(1,32000)."'); background-color: #000;\"></div>";
        }
        echo $html;
        // it releases the associated results
        mysqli_free_result($results);
        disconnect($db);
        return true;
    }
    return true;
}

function getCarouselIndicators() {
    $db = connect();
    if ($db != NULL) {

        //Specification of the SQL query
        $query="SELECT name FROM carousel C";
        // Query execution; returns identifier of the result group
        $results = $db->query($query);
         // cycle to explode every line of the results
        $html = '';
        $i = 1;
        $fila = mysqli_fetch_array($results, MYSQLI_BOTH);
        while ($fila = mysqli_fetch_array($results, MYSQLI_BOTH)) {
            // Options: MYSQLI_NUM to use only numeric indexes
            // MYSQLI_ASSOC to use only name (string) indexes
            // MYSQLI_BOTH, to use both
            $html .= "<li data-target=\"#carouselExampleIndicators\" data-slide-to=\"{$i}\"></li>";
            $i++;
        }
        echo $html;
        // it releases the associated results
        mysqli_free_result($results);
        disconnect($db);
        return true;
    }
    return true;
}

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
        $i = 1;
        while ($fila = mysqli_fetch_array($results, MYSQLI_BOTH)) {
            // Options: MYSQLI_NUM to use only numeric indexes
            // MYSQLI_ASSOC to use only name (string) indexes
            // MYSQLI_BOTH, to use both
            $html .= "  <li class=\"collection\">
                            <a class=\"collection-image\" href=\"gallery.php?id=".$fila["id"]."\" style=\"background-image: url('gallery/".$fila["id"]."/".$fila["img_name"]."_".$fila["cover"]."_thumb.".$fila["type"]."?".rand(1,32000)."');\"
                            data-image-full=\"gallery/".$fila["id"]."/".$fila["img_name"]."_".$fila["cover"].".".$fila["type"]."?".rand(1,32000)."\">
                                <img src=\"gallery/".$fila["id"]."/".$fila["img_name"]."_".$fila["cover"]."_thumb.".$fila["type"]."?".rand(1,32000)."\" alt=\"Gallery \" />
                            </a>
                            <a class=\"collection-description\" href=\"gallery.php?id=".$fila["id"]."\">
                                <h2>".$fila["name"]."</h2>
                            </a>
                        </li>";
        }
        echo $html;
        // it releases the associated results
        mysqli_free_result($results);
        disconnect($db);
        return true;
    }
    return true;
}

function getImages($collection_id) {
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

        $html = "";
        $i = 1;
        while ($fila = mysqli_fetch_array($results, MYSQLI_BOTH)) {
            // Options: MYSQLI_NUM to use only numeric indexes
            // MYSQLI_ASSOC to use only name (string) indexes
            // MYSQLI_BOTH, to use both
            $html .=   "<img src=\"gallery/".$fila["id_collection"]."/".$fila["name"]."_".$fila["id_image"]."_thumb.".$fila["type"]."?".rand(1,32000)."\" data-full=\"gallery/".$fila["id_collection"]."/".$fila["name"]."_".$fila["id_image"].".".$fila["type"]."\" class=\"m-p-g__thumbs-img\" />";
        }
        echo $html;
        // it releases the associated results
        mysqli_free_result($results);
        disconnect($db);
        return true;
    }
    return false;
}

function getBio() {
    $db = connect();
    if ($db != NULL) {
        // insert command specification
        $query="SELECT * FROM content WHERE section = 'bio'";
        // Preparing the statement
        $results = $db->query($query);

        if ($fila = mysqli_fetch_array($results, MYSQLI_BOTH)) {
            // Options: MYSQLI_NUM to use only numeric indexes
            // MYSQLI_ASSOC to use only name (string) indexes
            // MYSQLI_BOTH, to use both
            // it releases the associated results
            mysqli_free_result($results);
            disconnect($db);
            return $fila["text"];
        }
        // it releases the associated results
        mysqli_free_result($results);
        disconnect($db);
        return false;
    }
    return false;
}

function getBioPic() {
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
            return "content/".$fila["text"];
        }
        // it releases the associated results
        mysqli_free_result($results);
        disconnect($db);
        return "images/add-icon.png";
    }
    return "images/add-icon.png";
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
            return "background-image: url('content/".$fila["text"]."?".rand(1,32000)."')";
        }
        // it releases the associated results
        mysqli_free_result($results);
        disconnect($db);
        return "background-image: url('images/add-icon.png')";
    }
    return "background-image: url('images/add-icon.png')";
}

function getQuotes() {
    $db = connect();
    if ($db != NULL) {

        //Specification of the SQL query
        $query="SELECT quote, author FROM quotes";

        // Query execution; returns identifier of the result group
        $results = $db->query($query);
         // cycle to explode every line of the results
        $html = '';
        while ($fila = mysqli_fetch_array($results, MYSQLI_BOTH)) {
            // Options: MYSQLI_NUM to use only numeric indexes
            // MYSQLI_ASSOC to use only name (string) indexes
            // MYSQLI_BOTH, to use both
            $quote = $fila["quote"];
            $author = $fila["author"];
            $html .=   "<div class=\"blockquote text-center inner\">
                            <p class=\"mb-0\">{$quote}</p>
                            <footer class=\"blockquote-footer\"><cite title=\"Source Title\">{$author}</cite></footer>
                        </div>";
        }
        // it releases the associated results
        mysqli_free_result($results);
        disconnect($db);
        return $html;
    }
    return true;
}

?>
