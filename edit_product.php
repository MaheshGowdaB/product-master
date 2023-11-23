<?php
include "connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize form data
    $productCode = $_POST['productCode'];
    $productName = $_POST['productName'];
    $UOM = $_POST['UOM'];
    $stock = $_POST['stock'];
    $sellingPrice = $_POST['sellingPrice'];
    $offerPrice = $_POST['offerPrice'];
    $productImage = $_POST['productImage'];

    // SQL query to update product details
    $sql = "UPDATE tblproducts SET
            product_name='$productName',
            UOM='$UOM',
            stock='$stock',
            selling_price='$sellingPrice',
            offer_price='$offerPrice',
            product_image='$productImage'
            WHERE product_code='$productCode'";

    if ($conn->query($sql) === TRUE) {
        header('Location: product_master.html'); // Redirect to product master page
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>