<?php
require_once "../../includes/initialize.php";

if (!$session->is_logged_in()) {
    redirect_to("login.php");
}
//Don't see this right now

if (isset($_POST['submit'])) {

    if (!empty($_POST['item_id']) && !empty($_POST['quantity'])) {
        $stock = new Stock();
        $stock->item_id = $_POST['item_id'];
        $stock->quantity = $_POST['quantity'];
        $stock->date = strftime('%Y/%m/%d %H:%M:%S', time());

        $existing_stock = Stock::find_item_in_stock($_POST['item_id']);
        if (empty($existing_stock)) {
            if ($stock->save()) {
                $session->message = "Stock successfully saved";
            } else {
                $session->message = "Couldn't Saved the item";
            }
        } else {
            $stock->id = $existing_stock->id;
            $stock->quantity = $existing_stock->quantity + $_POST['quantity'];
            if ($stock->save()) {
                $session->message = "Stock successfully updated";
            } else {
                $session->message = "Couldn't update the item";
            }
        }
    } else {
        $session->message = "Please fill all the information";
    }

}


$companies = Company::find_all();

?>
<?php include_layout_template("admin_header.php") ?>
    <script src="../js/jquery-3.1.1.js"></script>
    <h3>Stock in</h3>
<?php if (isset($session->message)) {
    echo($session->message);
} ?>
    <form action="stock_in.php" method="post" class="">
        <div class="form-group row">
            <label for="company_id" class="col-sm-3 col-form-label">Select Company:</label>
            <div class="col-sm-6">
                <select name="company_id" id="company_id" class="form-control" required>
                    <option value="" selected>select a value</option>
                    <?php foreach ($companies as $company): ?>
                        <option value="<?php echo $company->id ?>"><?php echo $company->name; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label for="item_id" class="col-sm-3 col-form-label">Select Item:</label>
            <div class="col-sm-6">
                <select name="item_id" id="item_id" class="form-control" required>
                    <option value="" selected>select a value</option>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label for="reorder_level" class="col-sm-3 col-form-label ">Reorder Level:</label>
            <div class="col-sm-6">
                <input type="text" id="reorder_level" name="reorder_level" class="form-control" disabled>
            </div>
        </div>
        <div class="form-group row">
            <label for="available_quantity" class="col-sm-3 col-form-label ">Available Quantity:</label>
            <div class="col-sm-6">
                <input type="text" id="available_quantity" name="available_quantity" class="form-control" disabled>
            </div>
        </div>
        <div class="form-group row">
            <label for="quantity" class="col-sm-3 col-form-label ">Stock in Quantity:</label>
            <div class="col-sm-6">
                <input type="number" name="quantity" class="form-control" required>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-sm-3"></div>
            <div class="col-sm-6">
                <input type="submit" value="Save" name="submit" class="btn btn-success">
            </div>
        </div>
    </form>

    <script>
        $(document).ready(function () {
            $("#company_id").change(function () {
                var company_id = $(this).val();
                $("#item_id").empty();
                $("#available_quantity").val("");
                $("#reorder_level").val("");
                var dataString = 'company_id=' + company_id;
                $.ajax
                ({
                    type: "POST",
                    dataType: 'json',
                    url: "getItem.php",
                    data: dataString,
                    cache: false,
                    success: function (objects) {
                        if (objects.length === 0) {
                            $("#item_id").append('<option selected="selected" value="">--No item found--</option>')
                        } else {
                            $("#item_id").append('<option selected="selected" value="">--Select an item--</option>');
                            $.each(objects, function (key, value) {
                                //alert(value.name);

                                $("#item_id").append('<option value=' + value.id + '>' + value.name + '</option>');

                            });
                        }
                        //console.log(objects)
                    }
                })
                /*$.ajax({
                 type: "POST",
                 dataType: 'json',
                 url: 'getItem.php',
                 data: { // request e_val
                 val : dataString
                 }
                 }).done(function(xhr) {
                 console.log(xhr);
                 if(xhr.name){
                 alert('response data is '+ xhr.name);
                 }
                 })*/
            });
            $("#item_id").change(function () {
                var item_id = $(this).val();
                var dataString = 'item_id=' + item_id;
                $("#available_quantity").val("");
                $("#reorder_level").val("");
                $.ajax
                ({
                    type: "POST",
                    dataType: 'json',
                    url: "getItem.php",
                    data: dataString,
                    //cache: false,
                    success: function (object) {
                        console.log(object);
                        if (object.length !== 0) {
                            $("#reorder_level").val(object.reorder_level);
                            $("#available_quantity").val(object.available_quantity);
                        }
                    }
                });

            });
        });
    </script>

<?php include_layout_template("admin_footer.php") ?>