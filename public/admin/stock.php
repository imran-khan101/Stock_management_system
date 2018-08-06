<?php
require_once "../../includes/initialize.php";

if (!$session->is_logged_in()) {
    redirect_to("login.php");
}

if (isset($_POST['items']) && isset($_POST['type'])) {

    $type=$_POST['type'];
    $items = json_decode($_POST['items']);
    header('Content-Type: application/json');
    if(Stock::update_stock($items,$type)){
        echo json_encode("Stock out successful");
    }else{
        echo json_encode("operation failed");
    }
    exit;
}