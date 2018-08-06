<?php
require_once "../../includes/initialize.php";

if (!$session->is_logged_in()) {
    redirect_to("login.php");
}
$message = "Please fill up the following information";
if (isset($_POST['submit'])) {
    if (!empty($_POST['name']) && !empty($_POST['category_id']) && !empty($_POST['company_id']) && !empty($_POST['reorder_level'])) {
        $item = new Item();
        $item->name = $_POST['name'];
        $item->category_id = $_POST['category_id'];
        $item->company_id = $_POST['company_id'];
        $item->reorder_level = $_POST['reorder_level'];
        if ($item->save()) {
            $session->message("Item successfully saved");
        } else {
            $session->message("Couldn't Saved the item");
        }
    } else {
        $message = "Please fill all the information";
    }
}

$categories = Category::find_all();
$companies = Company::find_all();
$sl = 1;
?>
<?php include_layout_template("admin_header.php") ?>

<h3>Setup an Item</h3>
<?php if (isset($session->message)) {
    echo output_message($session->message);
} ?>
<?php echo output_message($message); ?>

<form action="setup_item.php" method="post" class="">
    <div class="form-group row">
        <label for="category_id" class="col-sm-3 col-form-label ">Select Category:</label>
        <div class="col-sm-6">
            <select name="category_id" id="" class="form-control" required>
                <option value="" selected>select a value</option>
                <?php foreach ($categories as $category): ?>
                    <option value="<?php echo $category->id ?>"><?php echo $category->name; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <div class="form-group row">
        <label for="company_id" class="control-label col-sm-3">Select Company: </label>
        <div class="col-sm-6">
            <select name="company_id" id="" class="form-control" required>
                <option value="" selected>select a value</option>
                <?php foreach ($companies as $company): ?>
                    <option value="<?php echo $company->id ?>"><?php echo $company->name; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    <div class="form-group row">
        <label for="name" class="control-label col-sm-3">Item Name:</label>
        <div class="col-sm-6">
            <input type="text" name="name" class="form-control">
        </div>
    </div>
    <div class="form-group row">
        <label for="reorder_level" class="control-label col-sm-3">Reorder Level:</label>
        <div class="col-sm-6">
            <input type="number" name="reorder_level" class="form-control">

        </div>
    </div>
    <div class="form-group row">
        <div class="col-sm-3"></div>
        <div class="col-sm-6">
            <input type="submit" value="Save" name="submit" class="btn btn-success">
        </div>
    </div>
</form>

<?php include_layout_template("admin_footer.php") ?>
