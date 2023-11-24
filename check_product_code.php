<?php
include('connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $productCode = $_POST['productCode'];

    // Check if the product code already exists
    $checkProductCode = "SELECT * FROM tblproducts WHERE product_code = '$productCode'";
    $resultProductCode = $conn->query($checkProductCode);

    if ($resultProductCode->num_rows > 0) {
        $response['status'] = 'error';
        $response['message'] = "Product code \"$productCode\" already exists. Please choose a different product code.";
    } else {
        $response['status'] = 'success';
        $response['message'] = "Product code is available.";
    }

    // Return the response as JSON
    header('Content-Type: application/json');
    echo json_encode($response);
}
?>