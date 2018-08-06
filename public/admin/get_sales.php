<?php
require_once "../../includes/initialize.php";
require_once "../../includes/view_salesVM.php";
if (!$session->is_logged_in()) {
    redirect_to("login.php");
}
if (isset($_POST['from_date']) || isset($_POST['to_date'])) {
    $from_date = $_POST['from_date'];
    $to_date = $_POST['to_date'];
    $items = ViewSalesVM::get_sales_by_date($from_date,$to_date);

    header('Content-Type: application/json');
    echo json_encode($items);
    exit;
}