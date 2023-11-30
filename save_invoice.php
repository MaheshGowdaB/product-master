<?php
include "connection.php";

// Check if 'invoiceData' is provided in the POST request
if (isset($_POST['invoiceData']) && !empty($_POST['invoiceData'])) {
    $invoiceData = json_decode($_POST['invoiceData'], true);

    // Initialize total quantity
    $totalQty = 0;

    // Iterate through each row's data and calculate total quantity
    foreach ($invoiceData as $rowData) {
        $totalQty += $rowData['qty'];
    }

    // Use the first row's data to insert a single row into tblinvhead
    $firstRowData = $invoiceData[0];

    $sql = "INSERT INTO tblinvhead (InvoiceNo, InvoiceDate, CustomerName, MobileNo, Qty, NetTotal, Saved_By, SavedDateTime)
            VALUES ('$firstRowData[invoiceNo]', '$firstRowData[invoiceDate]', '$firstRowData[customerName]', '$firstRowData[mobileNo]', '$totalQty', '$firstRowData[netTotal]', '$firstRowData[savedBy]', '$firstRowData[savedDateTime]')";

    $result = $conn->query($sql);

    if (!$result) {
        die("Invalid query: " . $conn->error);
    }

    // Update stock in tblproducts for each product code
    foreach ($invoiceData as $rowData) {
        $productCode = $rowData['productCode'];
        $qty = $rowData['qty'];

        $updateStockSql = "UPDATE tblproducts SET stock = stock - '$qty' WHERE product_code = '$productCode'";
        $updateStockResult = $conn->query($updateStockSql);

        if (!$updateStockResult) {
            die("Invalid query: " . $conn->error);
        }
    }

    // Close the database connection
    $conn->close();

    echo 'success'; // Send a success response to the client
} else {
    // Handle the case where 'invoiceData' is not provided in the POST request
    echo 'error';
}
?>
