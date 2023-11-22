<?php
include "connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_code = $_POST['product_code'];
    $product_name = $_POST['product_name'];
    $UOM = $_POST['UOM'];
    $stock = $_POST['stock'];
    $selling_price = $_POST['selling_price'];
    $offer_price = $_POST['offer_price'];
    $product_image = $_POST['product_image'];

    $sql = "UPDATE tblproducts SET product_code='$product_code', product_name='$product_name', UOM='$UOM', stock='$stock', selling_price='$selling_price' , offer_price='$offer_price',  product_image='$product_image' WHERE product_code='$product_code'";

    if ($conn->query($sql) === TRUE) {
        header('Location: product_master.html');
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>