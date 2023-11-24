<?php
include "connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve values from the form
    $keyCode = $_POST['KeyCode'];
    $uomName = $_POST['UOMName'];
    $value = $_POST['Value'];

    // Validate and sanitize input (you can add more validation as needed)
    $keyCode = mysqli_real_escape_string($conn, $keyCode);
    $uomName = mysqli_real_escape_string($conn, $uomName);
    $value = mysqli_real_escape_string($conn, $value);

    // Update the database
    $sql = "UPDATE tbluom SET UOMName = '$uomName', Value = '$value' WHERE KeyCode = '$keyCode'";

    if ($conn->query($sql) === TRUE) {
        // Update successful
        $response = array('status' => 'success', 'message' => 'UOM updated successfully');
        echo json_encode($response);

        // Additional step: Add the redirection to uom_master.html
        if ($response['status'] === 'success') {
            header('Location: uom_master.html');
            exit;  // Make sure to exit after the redirection
        }
    } else {
        // Update failed
        echo json_encode(array('status' => 'error', 'message' => 'Error updating UOM'));
    }
} else {
    // Invalid request method
    echo json_encode(array('status' => 'error', 'message' => 'Invalid request method'));
}

// Close the database connection
$conn->close();
?>
