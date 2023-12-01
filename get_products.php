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
} elseif (isset($_GET['search']) && !empty($_GET['search'])) {
    $search_text = $_GET['search'];

    // Fetch products based on search criteria
    $sql = "SELECT *, offer_price AS actual_offer_price FROM tblproducts WHERE 
            product_code LIKE '%$search_text%' OR
            product_name LIKE '%$search_text%' OR
            UOM LIKE '%$search_text%' OR
            stock LIKE '%$search_text%' OR
            selling_price LIKE '%$search_text%' OR
            offer_price LIKE '%$search_text%' OR
            product_image LIKE '%$search_text%'";
} else {
    // Handle the case where neither 'product_code', 'product_name', nor 'search' is provided in the request
    echo json_encode(['error' => 'Product code, product name, or search criteria not provided']);
    exit();
}

$result = $conn->query($sql);

if (!$result) {
    die("Invalid query: " . $conn->error);
}

// Initialize an empty array to store the results
$data = array();

if (isset($productCode) || isset($productName)) {
    // If a single product is requested, push the result into the data array
    if ($row = $result->fetch_assoc()) {
        $data = $row;
    } else {
        $data['error'] = isset($productCode) ? 'No data found for the product code' : 'No data found for the product name';
    }
} else {
    // If multiple products are requested, push each row into the data array
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

// Close the database connection
$conn->close();

// Send the JSON-encoded data as the response
header('Content-Type: application/json');
echo json_encode($data);
?>
