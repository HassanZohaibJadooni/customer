<?php
include "class.php";

$customer = new Customer();
$action = $_POST['action'] ?? "";

// Add customer
if ($action == "add") {
    $customer->create($_POST['name'], $_POST['email'], $_POST['phone']);
}

// Update customer
if ($action == "update") {
    $customer->update($_POST['id'], $_POST['name'], $_POST['email'], $_POST['phone']);
}

// Delete customer
if ($action == "delete") {
    $customer->delete($_POST['id']);
}

// Read all customers
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

// Get one customer for edit
if ($action == "getOne") {
    $customers = $customer->read();
    foreach ($customers as $c) {
        if ($c["id"] == $_POST['id']) {
            echo json_encode($c);
            break;
        }
    }
}
