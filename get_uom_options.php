<?php
include "connection.php";

$sql = "SELECT UOMName FROM tbluom";  // Adjust the table and column names if needed

$result = $conn->query($sql);

if (!$result) {
    die("Invalid query!");
}

// Initialize an empty array to store the results
$data = array();

while ($row = $result->fetch_assoc()) {
    // Push each UOMName into the data array
    $data[] = $row;
}

// Close the database connection
$conn->close();

// Send the JSON-encoded data as the response
header('Content-Type: application/json');
echo json_encode($data);
?>
