<?php
require_once "../../includes/initialize.php";

if (!$session->is_logged_in()) {
    redirect_to("login.php");
}
if (!isset($_GET['id'])) {
    redirect_to('setup_category.php');
} else {
    $category = Category::find_by_id(trim($_GET['id']));
    if ($category && $category->delete()) {
        $session->message("Successfully deleted");
        redirect_to('setup_category.php');
    }
}