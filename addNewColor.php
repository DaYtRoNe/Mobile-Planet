<?php

require "connection.php";

if (isset($_GET["d"])) {

    $clr = $_GET["d"];

    if(!empty($clr)){
        Database::iud("INSERT INTO `color` (`clr_name`) VALUES ('".$clr."')");

        echo("success");
    }

}

?>