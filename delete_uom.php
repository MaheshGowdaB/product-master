<?php
include "connection.php";

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['keyCode'])) {
    // Retrieve the Key Code from the query parameters
    $keyCode = $_GET['keyCode'];

    // Validate and sanitize input (you can add more validation as needed)
    $keyCode = mysqli_real_escape_string($conn, $keyCode);

    // Delete from the database
    $sql = "DELETE FROM tbluom WHERE KeyCode = '$keyCode'";

    if ($conn->query($sql) === TRUE) {
        // Deletion successful
        echo json_encode(array('status' => 'success', 'message' => 'UOM deleted successfully'));
    } else {
        // Deletion failed
        echo json_encode(array('status' => 'error', 'message' => 'Error deleting UOM'));
    }
} else {
    // Invalid request method or missing parameters
    echo json_encode(array('status' => 'error', 'message' => 'Invalid request or missing parameters'));
}

// Close the database connection
$conn->close();
?>
