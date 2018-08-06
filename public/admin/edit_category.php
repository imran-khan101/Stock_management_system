<?php
require_once "../../includes/initialize.php";

if (!$session->is_logged_in()) {
    redirect_to("login.php");
}
if (!isset($_GET['id']) && !isset($_POST['submit'])) {
    redirect_to('setup_category.php');
}
$id = "";
$name = "";
if (isset($_GET['id'])) {
    $message = "Please enter the new category name";
    $category = Category::find_by_id(trim($_GET['id']));
    $name = $category->name;
    $id = $category->id;
}
if (isset($_POST['submit'])) {

    if (!empty($_POST['name'])) {
        $category = new Category();
        $category->id = $_POST['id'];
        $category->name = $_POST['name'];
        if ($category->save()) {
            $session->message("Category Updated");
            redirect_to('setup_category.php');
        } else {
            $message = "Couldn't Saved the Category";
        }
    }
}
?>
<?php include_layout_template("admin_header.php") ?>
<h3><a href="setup_category.php">&laquo;Back</a></h3>
<h2>Edit Category</h2>
<?php echo output_message($message); ?>
<form action="edit_category.php" method="post">
    <input type="hidden" name="id" value="<?php echo $id; ?>">
    Name: <input type="text" name="name" value="<?php echo $name ?>"> <br>

    <input type="submit" value="Save" name="submit">
</form>

<?php include_layout_template("admin_footer.php") ?>
