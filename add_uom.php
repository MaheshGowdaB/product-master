<?php
include "connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve values from the form
    $uomName = $_POST['UOMName'];
    $value = $_POST['Value'];

    // Validate and sanitize input (you can add more validation as needed)
    $uomName = mysqli_real_escape_string($conn, $uomName);
    $value = mysqli_real_escape_string($conn, $value);

    // Get the current username from the form data
    $saved_by = isset($_POST["username"]) ? $_POST["username"] : "Guest";

    // Get the current date and time
    $SavedDateTime = date("Y-m-d H:i:s");

    // Insert into database
    $sql = "INSERT INTO tbluom (UOMName, Value, saved_by, SavedDateTime) VALUES ('$uomName', '$value', '$saved_by', '$SavedDateTime')";

    if ($conn->query($sql) === TRUE) {
        // Insertion successful
        $response = array('status' => 'success', 'message' => 'UOM added successfully');

        // Send response as JSON
        echo json_encode($response);
    } else {
        // Insertion failed
        $response = array('status' => 'error', 'message' => 'Error adding UOM');

        // Send response as JSON
        echo json_encode($response);
    }
} else {
    // Invalid request method
    $response = array('status' => 'error', 'message' => 'Invalid request method');

    // Send response as JSON
    echo json_encode($response);
}

// Close the database connection
$conn->close();
?>
