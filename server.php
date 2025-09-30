<?php
// file ko include krdeya class wala
include "class.php";

// object create kar deya
$customer = new Customer();

$action = $_POST['action'] ?? ""; // yeh action wait kar raha hay kay konsa action hoga ose hisab say phir code chalayega

// Add customer 
if ($action == "add") {
    $customer->create($_POST['name'], $_POST['email'], $_POST['phone']);
}

//update customer
if ($action == "update") {
    $customer->update($_POST['id'], $_POST['name'], $_POST['email'], $_POST['phone']);
}

//Delete customer
if ($action == "delete") {
    $customer->delete($_POST['id']);
}

//Yeh deke gah kay agr data file me he to wo dynamically table row create karega or oske say dynamically 3 buttons create krega
if ($action == "read") {
    $customers = $customer->read();
    foreach ($customers as $c) {
        echo "<tr>
                <td>{$c['id']}</td>
                <td>{$c['name']}</td>
                <td>{$c['email']}</td>
                <td>{$c['phone']}</td>
                <td>
                    <button class='editBtn' style='background: blue;' data-id='{$c['id']}'>Edit</button>
                    <button class='deleteBtn' style='background: red;' data-id='{$c['id']}'>Delete</button>
                    <button class='detailsBtn' style='background: aqua;' data-id='{$c['id']}'>Details</button>
                </td>
              </tr>";
    }
}

// yeh update karne kay liye yani aik id wala pakre ga or ose ko update kr dega
if ($action == "getOne") {
    $customers = $customer->read();
    foreach ($customers as $c) {
        if ($c["id"] == $_POST['id']) {
            echo json_encode($c);
            break;
        }
    }
}
?>
