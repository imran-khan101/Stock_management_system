<?php
require_once "../../includes/initialize.php";

if (!$session->is_logged_in()) {
    redirect_to("login.php");
}
$companies = Company::find_all();
$categories = Category::find_all();
?>

<?php include_layout_template("admin_header.php") ?>
<script src="../js/jquery-3.1.1.js"></script>

<h3>Search and View Item Summary</h3>
<?php if (isset($session->message)) {
    echo($session->message);
} ?>

<form action="">
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
        <label for="company_id" class="col-sm-3 col-form-label">Select Category:</label>
        <div class="col-sm-6">
            <select name="category_id" id="category_id" class="form-control" required>
                <option value="" selected>select a value</option>
                <?php foreach ($categories as $category): ?>
                    <option value="<?php echo $category->id ?>"><?php echo $category->name; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-sm-3"></div>
        <div class="col-sm-2">
            <input id="search_button" type="button" value="Search" class="btn btn-success btn-block">
        </div>
    </div>
    <div class="form-group row">
        <div class="col-sm-3"></div>
        <div class="col-sm-6">
            <table id="item_table" class="table table-striped table-bordered">
                <tr class="success">
                    <th>sl</th>
                    <th>Item</th>
                    <th>Company</th>
                    <th>Category</th>
                    <th>Reorder Level</th>
                    <th>Available Quantity</th>
                </tr>
            </table>
        </div>
    </div>
</form>
<script>
    $(document).ready(function () {

        $("#search_button").click(function () {
            var company_id = $("#company_id").val();
            var category_id = $("#category_id").val();
            if(company_id || category_id){
                item_summary_search(company_id, category_id);
            }
        });
        function item_summary_search(company_id, category_id) {
            //alert("inside stock_Out !");
            if (company_id !== 0 || category_id !== 0) {
                $.ajax({
                    url: 'get_item_summary.php',
                    data: {company_id: company_id, category_id: category_id},
                    type: 'POST',
                    success: function (objects) {
                        if (objects !== null) {
                            /*console.log(objects);
                            var result = JSON.parse(objects);
                            */
                            add_to_item_table(objects);
                            console.log(objects)
                        } else {
                            alert("No item found");
                        }
                    }
                });
            } else {
                alert("Chose company or category");
            }
        }

        function add_to_item_table(item_list) {
            var counter = 1;
            $('#item_table>tr').not(function () {
                return !!$(this).has('th').length;
            }).remove();
            var table = document.getElementById('item_table');
            $.each(item_list, function (key, value) {

                var row = document.createElement('tr');
                var cell1 = document.createElement('td');
                var cell2 = document.createElement('td');
                var cell3 = document.createElement('td');
                var cell4 = document.createElement('td');
                var cell5 = document.createElement('td');
                var cell6 = document.createElement('td');

                cell1.innerHTML = counter;
                cell2.innerHTML = value.item_name;
                cell3.innerHTML = value.company_name;
                cell4.innerHTML = value.category_name;
                cell5.innerHTML = value.reorder_level;
                cell6.innerHTML = value.quantity;
                row.appendChild(cell1);
                row.appendChild(cell2);
                row.appendChild(cell3);
                row.appendChild(cell4);
                row.appendChild(cell5);
                row.appendChild(cell6);
                table.appendChild(row);
                counter++;
            });
        }
    });
</script>
<?php include_layout_template("admin_footer.php") ?>
