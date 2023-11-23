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

    // Check if the product code already exists in the database
    $checkDuplicateQuery = "SELECT * FROM tblproducts WHERE product_code = '$product_code'";
    $duplicateResult = $conn->query($checkDuplicateQuery);

    if ($duplicateResult->num_rows > 0) {
        // Product code already exists, show an error message in a popup
        echo "<script>
                alert('Product code \"$product_code\" already exists. Please choose a different product code.');
                window.history.back(); // Go back to the previous page
              </script>";
        exit; // Stop further execution
    } else {
        // Insert data into the database
        $insertQuery = "INSERT INTO tblproducts (product_code, product_name, UOM, stock, selling_price, offer_price, product_image, saved_by, SavedDateTime)
                        VALUES ('$product_code', '$product_name', '$UOM', '$stock', '$selling_price', '$offer_price', '$product_image', '$saved_by', '$savedDateTime')";

        if ($conn->query($insertQuery) === TRUE) {
            // Successfully added the product, redirect to the product_master.html page
            header('Location: product_master.html');
        } else {
            // Error in the SQL query
            echo "Error: " . $insertQuery . "<br>" . $conn->error;
        }
    }
}

// Close the database connection
$conn->close();
?>
