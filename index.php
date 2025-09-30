<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="style.css">
    <script src="jquerylibrary.js"></script>
</head>

<body>

    <!-- Form -->
    <button type="button" onclick="back()" id="back">X</button>
    <form id="myForm" style="display:none;">
        <h2 id="formTitle">Add Customer</h2>

        <input type="hidden" name="action" id="action" value="add">
        <div class="form-row">
            <input id="id" type="hidden" name="id">
        </div>
        <div class="form-row">
            <label for="name">Name:</label>
            <input id="name" type="text" name="name">
        </div>
        <div class="form-row">
            <label for="email">Email:</label>
            <input id="email" type="email" name="email">
        </div>
        <div class="form-row">
            <label for="phone">Phone:</label>
            <input id="phone" type="number" name="phone">
        </div>

        <button type="submit" id="submitBtn">Add</button>
    </form>

    <!-- Add new customer button -->
    <button type="button" id="addNewCustomer" onclick="popup()">Add New Customer</button>

    <!-- Table -->
    <table id="myTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>

    <!-- Details box -->
    <div id="detailsBox" style="display:none;"></div>

    <script>
        $(document).ready(function() {

            // Customers load
            function loadTable() {
                $.post("server.php", {
                    action: "read"
                }, function(data) {
                    $("#myTable tbody").html(data);
                });
            }
            loadTable();

            // Add / Update submit
            $("#myForm").on("submit", function(e) {
                e.preventDefault();
                $.post("server.php", $(this).serialize(), function() { // sare inputs ko string me convert krdo 
                    loadTable();
                    back();
                    $("#myForm")[0].reset(); // form ko reset kr do
                    $("#formTitle").text("Add Customer");
                    $("#submitBtn").text("Add");
                    $("#action").val("add");
                });
            });

            // Edit button
            $(document).on("click", ".editBtn", function() {
                var id = $(this).data("id");
                $.post("server.php", {
                    action: "getOne",
                    id: id
                }, function(res) {
                    var c = JSON.parse(res); //file se jab data bhejte hain wo string hota hai. JSON.parse (res) is string ko object banata hai, taki tum c.id, c.name, c.email asani se use kar sako.
                    $("#id").val(c.id);
                    $("#name").val(c.name);
                    $("#email").val(c.email);
                    $("#phone").val(c.phone);
                    $("#action").val("update");
                    $("#formTitle").text("Edit Customer");
                    $("#submitBtn").text("Update");
                    popup();
                });
            });

            // Delete button
            $(document).on("click", ".deleteBtn", function() {
                if (confirm("Are you sure to confirm to delete this customer?")) {
                    var id = $(this).data("id");
                    $.post("server.php", {
                        action: "delete",
                        id: id
                    }, function() {
                        loadTable();
                    });
                }
            });

            // Details button
            $(document).on("click", ".detailsBtn", function() {
                var id = $(this).data("id"); // yahan se us button ka ID mil gaya
                $.post("server.php", {
                    action: "getOne",
                    id: id
                }, function(res) {
                    var c = JSON.parse(res); // res ko JS object me convert kiya
                    alert("ID: " + c.id + "\nName: " + c.name + "\nEmail: " + c.email + "\nPhone: " + c.phone);
                });
            });

        });

        // Show/Hide
        function popup() {
            $("#myForm").show();
            $("#myTable").hide();
            $("#addNewCustomer").hide();
            $("#detailsBox").hide();
            $("#back").show(); // show back button
        }

        function back() {
            $("#myForm").hide();
            $("#myTable").show();
            $("#addNewCustomer").show();

            $("#back").hide(); // hide again
        }
    </script>
</body>

</html>