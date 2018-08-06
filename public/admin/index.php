<?php

require_once "../../includes/initialize.php";


if (!$session->is_logged_in()) {
    redirect_to("login.php");
}

?>

<?php include_layout_template("admin_header.php") ?>
<h2>Menu</h2>
<?php echo output_message($session->message()); ?>
<ul class="ul">
    <li><a href="logfile.php">View logs</a></li>
    <li><a href="setup_item.php">Setup an item</a></li>
    <li><a href="setup_category.php">Setup Category</a></li>
    <li><a href="setup_company.php">Set up company</a></li>
    <li><a href="stock_in.php">Stock In</a></li>
    <li><a href="stock_out.php">Stock Out</a></li>
    <li><a href="item_summary.php">Item Summary</a></li>
    <li><a href="sales_view.php">View Sales</a></li>
    <li><a href="logout.php">Logout</a></li>
</ul>

<?php include_layout_template("admin_footer.php") ?>

