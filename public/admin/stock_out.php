<?php
require_once "../../includes/initialize.php";

if (!$session->is_logged_in()) {
    redirect_to("login.php");
}

$companies = Company::find_all();

?>
<?php include_layout_template("admin_header.php") ?>
    <script src="../js/jquery-3.1.1.js"></script>
    <h3>Stock Out</h3>
<?php if (isset($session->message)) {
    echo($session->message);
} ?>
    <form action="stock_in.php" method="post" class="" id="stock_out_form">
        <div class="form-group row">
            <label for="company_id" class="col-sm-3 col-form-label">Select Company:</label>
            <div class="col-sm-6">
                <select name="company_id" id="company_id" class="form-control" required>
                    <option value="default" selected>--Select a Company--</option>
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
                    <option value="default" selected>--Select a Value--</option>
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
            <label for="quantity" class="col-sm-3 col-form-label ">Stock out Quantity:</label>
            <div class="col-sm-6">
                <input type="number" name="quantity" class="form-control" id="quantity" required>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-sm-3"></div>
            <div class="col-sm-6">
                <input id="add_button" type="button" value="Add to list" class="btn btn-success ">
            </div>
        </div>
    </form>
    <div class="form-group row">
        <div class="col-sm-3"></div>
        <div class="col-sm-6">
            <table id="item_table" class="table table-striped table-bordered">
                <tr class="success">
                    <th>sl</th>
                    <th>Item</th>
                    <th>Company</th>
                    <th>Quantity</th>
                </tr>
            </table>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-sm-3"></div>
        <div class="col-sm-2">
            <input id="sell_button" type="button" value="Sell" class="btn btn-success btn-block">
        </div>
        <div class="col-sm-2">
            <input id="damage_button" type="button" value="Damage" class="btn btn-warning btn-block">
        </div>
        <div class="col-sm-2">
            <input id="lost_damage" type="button" value="Lost" class="btn btn-danger btn-block">
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $("#company_id").change(function () {
                var company_id = $(this).val();
                $("#item_id").empty();
                $("#available_quantity").val("");
                $("#reorder_level").val("");
                $("#quantity").val("");
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
                            $("#item_id").append('<option selected="selected" value="default">--No item found--</option>')
                        } else {
                            $("#item_id").append('<option selected="selected" value="default">--Select an item--</option>');
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

            var items_list = [];
            $("#add_button").click(function () {
                var item_id = $("#item_id>option:selected").val();
                var item_name = $("#item_id>option:selected").text();
                var company_id = $("#company_id>option:selected").val();
                var company_name = $("#company_id>option:selected").text();
                var quantity = $("#quantity").val();
                var item = {
                    item_id: item_id,
                    item_name: item_name,
                    company_id: company_id,
                    company_name: company_name,
                    quantity: quantity
                };
                var previous_quantity = item_exists(items_list, item);
                if (previous_quantity) {
                    item.quantity = eval(quantity) + eval(previous_quantity);
                    $.each(items_list, function (key, value) {
                        if (item.item_id === value.item_id) {
                            if (eval(item.quantity) > eval($("#available_quantity").val())) {
                                alert("Exceeding stock amount");
                            } else {
                                items_list[key] = item;
                                add_to_item_table(items_list);
                            }
                        }
                    });

                } else {
                    if (eval(item.quantity) > eval($("#available_quantity").val())) {
                        alert("Exceeding stock amount");
                    } else {
                        if (item.company_id !== 'default' && item.item_id !== 'default' && item.quantity !== "") {
                            items_list.push(item);
                            add_to_item_table(items_list);
                            //console.log(items_list);
                            $(this).closest('form').find("input[type=text],input[type=number],select").val("");
                        } else {
                            alert("PLease fill up all required data");
                        }
                    }

                }
            });

            var counter = 1;

            function add_to_item_table(item_list) {
                //$("#item_table").empty();
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

                    cell1.innerHTML = counter;
                    cell2.innerHTML = value.item_name;
                    cell3.innerHTML = value.company_name;
                    cell4.innerHTML = value.quantity;
                    row.appendChild(cell1);
                    row.appendChild(cell2);
                    row.appendChild(cell3);
                    row.appendChild(cell4);
                    table.appendChild(row);
                    counter++;
                });
            }

            function item_exists(item_list, item) {
                var quantity = 0;
                $.each(item_list, function (key, value) {
                    if (item.item_id === value.item_id) {
                        quantity = value.quantity;
                    }
                });
                return quantity;
            }

            $("#sell_button").click(function () {
                stock_out('sell');
            });
            $("#damage_button").click(function () {
                stock_out('damage');
            });
            $("#lost_button").click(function () {
                stock_out('lost');
            });
            //To send javascript obj to php using json and ajax:
            //js:
            function stock_out(type) {
                //alert("inside stock_Out !");
                if (items_list.length !== 0) {
                    var dataString = JSON.stringify(items_list);
                    $.ajax({
                        url: 'stock.php',
                        data: {items: dataString, type: type},
                        type: 'POST',
                        success: function (response) {
                            alert(response);
                            $(this).closest('form').find("input[type=text],input[type=number], select").val("");
                            items_list = [];
                            add_to_item_table(items_list);
                        }
                    });
                } else {
                    alert("Add some product to the list");
                }
            }

            function clear_fields() {
                $("#item_id").empty();
                $("#available_quantity").val("");
                $("#reorder_level").val("");
                $("#quantity").val("");
            }
        });
    </script>

<?php include_layout_template("admin_footer.php") ?>