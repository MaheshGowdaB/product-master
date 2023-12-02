<?php
include 'connection.php';

$query = "SELECT MAX(InvoiceNo) AS MaxInvoiceNo FROM tblinvhead";
$result = $conn->query($query);

if ($result) {
    $row = $result->fetch_assoc();
    $maxInvoiceNo = $row['MaxInvoiceNo'];

    // Increment the max InvoiceNo by 1
    $nextInvoiceNo = $maxInvoiceNo + 1;

    // Return the next InvoiceNo
    echo json_encode([$nextInvoiceNo]);
} else {
    echo json_encode([]);
}

$conn->close();
?>
