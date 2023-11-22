<?php
include "connection.php";

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $product_code = $_GET['id'];

    // Use prepared statement to prevent SQL injection
    $sql = "DELETE FROM tblproducts WHERE product_code = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $product_code);

    if ($stmt->execute()) {
        header('Location: product_master.html');
    } else {
        echo "Error deleting record: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request.";
}
?>
