<?php
include "connection.php";

$data = array();

if (isset($_GET['product_code']) && !empty($_GET['product_code'])) {
    $productCode = $_GET['product_code'];

    $sql = "SELECT product_name, UOM, selling_price, offer_price FROM tblproducts WHERE product_code = '$productCode'";
} elseif (isset($_GET['product_name']) && !empty($_GET['product_name'])) {
    $productName = $_GET['product_name'];

    $sql = "SELECT * FROM tblproducts WHERE product_name = '$productName'";
} else {
    $data['error'] = 'Product code or product name not provided';
    echo json_encode($data);
    exit();
}

$result = $conn->query($sql);

if (!$result) {
    $data['error'] = 'Invalid query: ' . $conn->error;
} elseif ($row = $result->fetch_assoc()) {
    $data = $row;
} else {
    $data['error'] = isset($productCode) ? 'No data found for the product code' : 'No data found for the product name';
}

$conn->close();

header('Content-Type: application/json');
echo json_encode($data);
?>
