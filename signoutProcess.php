<?php

session_start();

if (isset($_SESSION["u"])) {

    $_SESSION["u"] = null;
    session_destroy();

    echo ("success");
} else if (isset($_SESSION["a"])) {
    $_SESSION["a"] = null;
    session_destroy();

    echo ("success");
}
