<?php
include "connection.php";

// Check if 'uomCode' is provided in the request
if (isset($_GET['uomCode']) && !empty($_GET['uomCode'])) {
    $uomCode = $_GET['uomCode'];

    // Fetch UOMName for the selected UOMCode
    $sql = "SELECT UOMName FROM tbluom WHERE KeyCode = '$uomCode'";

    $result = $conn->query($sql);

    if (!$result) {
        die("Invalid query: " . $conn->error);
    }

    // Initialize an empty array to store the result
    $data = array();

    if ($row = $result->fetch_assoc()) {
        // If a row is found, push it into the data array
        $data = $row;
    } else {
        // If no row is found, provide default values or handle it as needed
        $data['UOMName'] = ''; // Default value
    }

    // Close the database connection
    $conn->close();

    // Send the JSON-encoded data as the response
    header('Content-Type: application/json');
    echo json_encode($data);
} else {
    // Handle the case where 'uomCode' is not provided in the request
    echo json_encode(['error' => 'UOM code not provided']);
}
?>
