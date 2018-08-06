<?php
require_once "../../includes/initialize.php";

if (!$session->is_logged_in()) {
    redirect_to("login.php");
}
if (isset($_POST['company_id']) && !isset($_POST['item_id'])) {
    $company_id = $_POST['company_id'];
    $items = Item::get_item_by_company_id($company_id);
    /*if (empty($items)) {
        echo "<option value=\"\">No items were found </option>";
    } else {
        foreach ($items as $item) {
            echo "<option value=\"" . $item->id . "\">{$item->name}</option>";
        }
    }*/

    header('Content-Type: application/json');
    echo json_encode($items);
    exit;
}
if (!isset($_POST['company_id']) && isset($_POST['item_id'])) {
    $item_id = $_POST['item_id'];
    $items = Item::find_by_id($item_id);
    $stock = Stock::find_item_in_stock($item_id);
    if ($stock) {
        $result = ["reorder_level" => $items->reorder_level, "available_quantity" => $stock->quantity];
    }else{
        $result = ["reorder_level" => $items->reorder_level, "available_quantity" => "0"];
    }
    header('Content-Type: application/json');
    echo json_encode($result);
    exit;
}

