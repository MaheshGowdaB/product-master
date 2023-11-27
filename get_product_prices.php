<?php
include "connection.php";

if (isset($_GET['product_name']) && !empty($_GET['product_name'])) {
    $product_name = $_GET['product_name'];

    // Fetch selling_price and offer_price for the selected product
    $sql = "SELECT selling_price, offer_price FROM tblproducts WHERE product_name = '$product_name'";

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
        $data['selling_price'] = 0;
        $data['offer_price'] = 0;
    }

    // Close the database connection
    $conn->close();

    // Send the JSON-encoded data as the response
    header('Content-Type: application/json');
    echo json_encode($data);
} else {
    // Handle the case where 'product_name' is not provided in the request
    echo json_encode(['error' => 'Product name not provided']);
}
?>
