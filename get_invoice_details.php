<?php

include('connection.php'); // Include the database connection script

// Retrieve invoiceNumber from the GET request
$invoiceNumber = $_GET['invoiceNumber'];

// Prepare and execute the query
$stmt = $conn->prepare("SELECT InvoiceNo, InvoiceDate, CustomerName, MobileNo, Qty, NetTotal FROM tblinvhead WHERE InvoiceNo = ?");
$stmt->bind_param("s", $invoiceNumber);
$stmt->execute();

// Get the result
$result = $stmt->get_result();

// Fetch data as an associative array
$data = $result->fetch_assoc();

// Close the database connection
$stmt->close();
$conn->close();

// Return data as JSON
echo json_encode($data);

?>
