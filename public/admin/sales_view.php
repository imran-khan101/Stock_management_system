<?php
require_once "../../includes/initialize.php";

if (!$session->is_logged_in()) {
    redirect_to("login.php");
}
$companies = Company::find_all();
$categories = Category::find_all();
?>
<?php include_layout_template("admin_header.php") ?>

<h3>Sales Between two Dates</h3>
<?php if (isset($session->message)) {
    echo($session->message);
} ?>

<form action="">
    <div class="form-group row">
        <label for="from_date" class="col-sm-3 col-form-label">From Date:</label>
        <div class="col-sm-6">
            <input type="text" id="from_date" class="date" placeholder="mm-dd-yy" required>
        </div>
    </div>
    <div class="form-group row">
        <label for="to_date" class="col-sm-3 col-form-label">To Date:</label>
        <div class="col-sm-6">
            <input type="text" id="to_date" placeholder="mm-dd-yy" class="date" required>
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
                    <th>Sale Quantity</th>
                </tr>
            </table>
        </div>
    </div>
</form>

<script>
    $(document).ready(function () {
        $("#from_date").datepicker({
            maxDate: new Date(),
            dateFormat: 'yy-mm-dd'
        });
        $("#to_date").datepicker({
            maxDate: new Date(),
            dateFormat: 'yy-mm-dd'
        });
        $("#search_button").click(function () {
            var from_date = $("#from_date").val();
            var to_date = $("#to_date").val();
            if (from_date || to_date) {
                sales_search(from_date, to_date);
            }
        });
        function sales_search(from_date, to_date) {
            //alert("inside stock_Out !");
            if (from_date !== 0 || to_date !== 0) {
                $.ajax({
                    url: 'get_sales.php',
                    data: {from_date: from_date, to_date: to_date},
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

                cell1.innerHTML = counter;
                cell2.innerHTML = value.item_name;
                cell3.innerHTML = value.quantity;
                row.appendChild(cell1);
                row.appendChild(cell2);
                row.appendChild(cell3);
                table.appendChild(row);
                counter++;
            });
        }
    });
</script>
<?php include_layout_template("admin_footer.php") ?>
