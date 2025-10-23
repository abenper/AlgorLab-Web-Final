<?php
    ob_start();
    require_once "./inc/session_start.php";
    include "./inc/head.php";


    $vista = isset($_GET['vista']) ? $_GET['vista'] : "home";

    if (is_file("./view/$vista.php")&& $vista != "404") {
        include "./inc/navbar.php";
        include "./view/$vista.php";
        include "./inc/script.php";  
    } else {
         include "./view/404.php";
    }

    include "./inc/foot.php";
    ob_end_flush();
?>