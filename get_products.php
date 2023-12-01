<?php
include "connection.php";

if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search_text = $_GET['search'];
    $sql = "SELECT *, offer_price AS actual_offer_price FROM tblproducts WHERE 
            product_code LIKE '%$search_text%' OR
            product_name LIKE '%$search_text%' OR
            UOM LIKE '%$search_text%' OR
            stock LIKE '%$search_text%' OR
            selling_price LIKE '%$search_text%' OR
            offer_price LIKE '%$search_text%' OR
            product_image LIKE '%$search_text%'";
} else {
    $sql = "SELECT *, offer_price AS actual_offer_price FROM tblproducts";
}

$result = $conn->query($sql);

if (!$result) {
    die("Invalid query!");
}

$data = array();

while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

$conn->close();

header('Content-Type: application/json');
echo json_encode($data);
?>
