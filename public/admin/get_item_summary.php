<?php
require_once "../../includes/initialize.php";

if (!$session->is_logged_in()) {
    redirect_to("login.php");
}
if (isset($_POST['company_id']) || isset($_POST['category_id'])) {
    $company_id = (int)$_POST['company_id'];
    $category_id = (int)$_POST['category_id'];
    $items = ItemSummary::get_item_summary($company_id,$category_id);


    header('Content-Type: application/json');
    echo json_encode($items);
    exit;
}