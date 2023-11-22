<?php
include "connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve data from the form
    $productCode = $_POST['product_code'];
    $productName = $_POST['product_name'];
    $UOM = $_POST['UOM'];
    $stock = $_POST['stock'];
    $sellingPrice = $_POST['selling_price'];
    $offerPrice = $_POST['offer_price'];
    $productImage = $_POST['product_image'];

    // Update the product details in the database
    $sql = "UPDATE tblproducts SET 
            product_name = '$productName',
            UOM = '$UOM',
            stock = '$stock',
            selling_price = '$sellingPrice',
            offer_price = '$offerPrice',
            product_image = '$productImage'
            WHERE product_code = '$productCode'";

    if ($conn->query($sql) === TRUE) {
        echo "Product details updated successfully";
    } else {
        echo "Error updating product details: " . $conn->error;
    }
} else {
    echo "Invalid request method";
}

$conn->close();
?>
