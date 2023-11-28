<?php
include "connection.php";

// Check if 'invoiceData' is provided in the POST request
if (isset($_POST['invoiceData']) && !empty($_POST['invoiceData'])) {
    $invoiceData = json_decode($_POST['invoiceData'], true);

    // Iterate through each row's data and insert into tblinvhead
    foreach ($invoiceData as $rowData) {
        $invoiceNo = $rowData['invoiceNo'];
        $invoiceDate = $rowData['invoiceDate'];
        $customerName = $rowData['customerName'];
        $mobileNo = $rowData['mobileNo'];
        $qty = $rowData['qty'];
        $netTotal = $rowData['netTotal'];
        $savedBy = $rowData['savedBy'];
        $savedDateTime = $rowData['savedDateTime'];
        $productCode = $rowData['productCode'];

        $sql = "INSERT INTO tblinvhead (InvoiceNo, InvoiceDate, CustomerName, MobileNo, Qty, NetTotal, Saved_By, SavedDateTime)
                VALUES ('$invoiceNo', '$invoiceDate', '$customerName', '$mobileNo', '$qty', '$netTotal', '$savedBy', '$savedDateTime')";

        $result = $conn->query($sql);

        if (!$result) {
            die("Invalid query: " . $conn->error);
        }

        // Update stock in tblproducts
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
