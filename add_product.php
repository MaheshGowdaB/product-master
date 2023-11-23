<?php
include "connection.php";


// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $product_code = $_POST["productCode"];
    $product_name = $_POST["productName"];
    $UOM = $_POST["UOM"];
    $stock = $_POST["stock"];
    $selling_price = $_POST["sellingPrice"];
    $offer_price = $_POST["offerPrice"];
    $product_image = $_POST["productImage"];

    // Get the current username from the form data
    $saved_by = isset($_POST["username"]) ? $_POST["username"] : "Guest";

    // Get the current date and time
    $savedDateTime = date("Y-m-d H:i:s");

    // Insert data into the database
    $sql = "INSERT INTO tblproducts (product_code, product_name, UOM, stock, selling_price, offer_price, product_image, saved_by, SavedDateTime)
            VALUES ('$product_code', '$product_name', '$UOM', '$stock', '$selling_price', '$offer_price', '$product_image', '$saved_by', '$savedDateTime')";

if ($conn->query($sql) === TRUE) {
    header('Location: product_master.html');
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
}

// Close the database connection
$conn->close();
?>