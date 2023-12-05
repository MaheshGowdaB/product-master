<?php
include 'connection.php';

// Query to fetch invoice numbers from tblinvhead
$sql = "SELECT InvoiceNo FROM tblinvhead";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Fetching data and creating an array
    $invoiceNumbers = array();
    while ($row = $result->fetch_assoc()) {
        $invoiceNumbers[] = $row['InvoiceNo'];
    }

    // Returning the array in JSON format
    echo json_encode($invoiceNumbers);
} else {
    echo json_encode(array()); // Return an empty array if no data found
}

$conn->close();
?>
