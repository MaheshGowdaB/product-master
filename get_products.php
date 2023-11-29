<?php
include "connection.php";

if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search_text = $_GET['search'];
    $sql = "SELECT * FROM tblproducts WHERE 
            product_code LIKE '%$search_text%' OR
            product_name LIKE '%$search_text%' OR
            UOM LIKE '%$search_text%' OR
            stock LIKE '%$search_text%' OR
            selling_price LIKE '%$search_text%' OR
            offer_price LIKE '%$search_text%' OR
            product_image LIKE '%$search_text%'";
} else {
    $sql = "SELECT * FROM tblproducts";
}

$result = $conn->query($sql);

if (!$result) {
    die("Invalid query!");
}

// Initialize an empty array to store the results
$data = array();

while ($row = $result->fetch_assoc()) {
    // Push each row into the data array
    $data[] = $row;
}

// Close the database connection
$conn->close();

// Send the JSON-encoded data as the response
header('Content-Type: application/json');
echo json_encode($data);
?>