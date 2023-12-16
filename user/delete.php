<?php

include("include/connect.php");
    if(isset($_GET['id'])){
    $id = $_GET['id'];
    $db->exec("DELETE FROM products where id = $id");
    header("location:services.php");
    }

    if(isset($_GET["ms"])){
        $id = $_GET["ms"];
        $id_pag = $_GET["id_pag"];
        $db->exec("DELETE FROM comments where id = $id");
        header("location:More_details.php?id=$id_pag");
    }

?>