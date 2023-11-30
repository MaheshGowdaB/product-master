<?php
include "connection.php";

if (isset($_GET['product_code']) && !empty($_GET['product_code'])) {
    $productCode = $_GET['product_code'];

    // Fetch product details for the selected product code
    $sql = "SELECT product_name, UOM, selling_price, offer_price FROM tblproducts WHERE product_code = '$productCode'";
} elseif (isset($_GET['product_name']) && !empty($_GET['product_name'])) {
    $productName = $_GET['product_name'];

    // Fetch all columns for the selected product name
    $sql = "SELECT * FROM tblproducts WHERE product_name = '$productName'";
} else {
    // Handle the case where neither 'product_code' nor 'product_name' is provided in the request
    echo json_encode(['error' => 'Product code or product name not provided']);
    exit();
}

$result = $conn->query($sql);

if (!$result) {
    die("Invalid query: " . $conn->error);
}

// Initialize an empty array to store the result
$data = array();

if ($row = $result->fetch_assoc()) {
    // If a row is found, push it into the data array
    $data = $row;
} else {
    // If no row is found, provide default values or handle it as needed
    $data['error'] = isset($productCode) ? 'No data found for the product code' : 'No data found for the product name';
}

// Close the database connection
$conn->close();

// Send the JSON-encoded data as the response
header('Content-Type: application/json');

// Add error messages for debugging
if (isset($data['error'])) {
    $data['query_error'] = $conn->error;
}

echo json_encode($data);
?>
