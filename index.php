<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Management</title>
    <link rel="stylesheet" href="style.css">
    <script src="jquerylibrary.js"></script>
</head>

<body>
    <div class="container">

        <div style="overflow: hidden; margin-bottom: 20px;">
            <h2 id="pageTitle" style="float: left;">Customer Management</h2>
            <button type="button" id="addNewCustomer">+ Add New Customer</button>
        </div>

        <form id="myForm" style="display:none;">
            <button type="button" id="back" title="Close">✕</button>
            <h2 id="formTitle">Add Customer</h2>
            <input type="hidden" name="action" id="action" value="add">
            <input id="id" type="hidden" name="id">

            <div class="form-row">
                <label for="name">Full Name</label>
                <input id="name" type="text" name="name" placeholder="John Doe" required>
            </div>

            <div class="form-row">
                <label for="email">Email Address</label>
                <input id="email" type="email" name="email" placeholder="john@example.com" required>
            </div>

            <div class="form-row">
                <label for="phone">Phone Number</label>
                <input id="phone" type="number" name="phone" placeholder="923001234567" required>
            </div>

            <button type="submit" id="submitBtn">Save Customer</button>
        </form>

        <div id="tableContainer">
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
        </div>

    </div>

    <script>
        $(function() {

            // Load table
            function loadTable() {
                $("#myTable tbody").css("opacity", "0.5");
                $.post("server.php", {
                    action: "read"
                }, function(data) {
                    $("#myTable tbody").html(data).css("opacity", "1");
                });
            }
            loadTable();

            // Add / Update
            $("#myForm").on("submit", function(e) {
                e.preventDefault();
                $.post("server.php", $(this).serialize(), function() {
                    loadTable();
                    back();
                });
            });

            // Show add form
            $("#addNewCustomer").click(function() {
                popup();
            });

            // Edit customer
            $(document).on("click", ".editBtn", function() {
                const id = $(this).data("id");
                $.post("server.php", {
                    action: "getOne",
                    id: id
                }, function(res) {
                    const c = JSON.parse(res);
                    $("#id").val(c.id);
                    $("#name").val(c.name);
                    $("#email").val(c.email);
                    $("#phone").val(c.phone);
                    $("#action").val("update");
                    $("#formTitle").text("Update Customer");
                    $("#submitBtn").text("Update Changes");
                    popup();
                });
            });

            // Delete customer
            $(document).on("click", ".deleteBtn", function() {
                const id = $(this).data("id");
                if (confirm("Are you sure want to delete this customer?")) {
                    $.post("server.php", {
                        action: "delete",
                        id: id
                    }, function() {
                        loadTable();
                    });
                }
            });

            // Details
            $(document).on("click", ".detailsBtn", function() {
                const id = $(this).data("id");
                $.post("server.php", {
                    action: "getOne",
                    id: id
                }, function(res) {
                    const c = JSON.parse(res);
                    alert("ID: " + c.id + "\nName: " + c.name + "\nEmail: " + c.email + "\nPhone: " + c.phone);
                });
            });

            // Popup helpers
            function popup() {
                $("#myForm").fadeIn(300);
                $("#tableContainer,#addNewCustomer,#pageTitle").hide();
            }

            function back() {
                $("#myForm").fadeOut(200, function() {
                    $("#tableContainer,#addNewCustomer,#pageTitle").fadeIn(300);
                    resetForm();
                });
            }
            $("#back").click(back);

            function resetForm() {
                $("#myForm")[0].reset();
                $("#action").val("add");
                $("#formTitle").text("Add Customer");
                $("#submitBtn").text("Save Customer");
            }

        });
    </script>
</body>

</html>