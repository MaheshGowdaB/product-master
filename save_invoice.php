<?php
include "connection.php";

// Check if 'invoiceData' is provided in the POST request
if (isset($_POST['invoiceData']) && !empty($_POST['invoiceData'])) {
    $invoiceData = json_decode($_POST['invoiceData'], true);

    // Initialize total quantity
    $totalQty = 0;

    try {
        // Start a database transaction
        $conn->begin_transaction();

        // Iterate through each row's data and calculate total quantity
        foreach ($invoiceData as $rowData) {
            $totalQty += $rowData['qty'];
        }

        // Use prepared statement for inserting data into tblinvhead
        $insertHeaderStmt = $conn->prepare("INSERT INTO tblinvhead (InvoiceNo, InvoiceDate, CustomerName, MobileNo, Qty, NetTotal, Saved_By, SavedDateTime) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $insertHeaderStmt->bind_param("ssssdsss", $invoiceNo, $invoiceDate, $customerName, $mobileNo, $totalQty, $netTotal, $savedBy, $savedDateTime);

        // Update stock in tblproducts for each product code
        foreach ($invoiceData as $rowData) {
            $productCode = $rowData['productCode'];
            $qty = $rowData['qty'];

            // Use prepared statement for updating stock
            $updateStockStmt = $conn->prepare("UPDATE tblproducts SET stock = stock - ? WHERE product_code = ?");
            $updateStockStmt->bind_param("ss", $qty, $productCode);

            // Execute the update stock query
            if (!$updateStockStmt->execute()) {
                throw new Exception("Error updating stock: " . $conn->error);
            }

            // Close the prepared statement
            $updateStockStmt->close();
        }

        // Bind parameters and execute the insert header query
        foreach ($invoiceData as $rowData) {
            extract($rowData);
            if (!$insertHeaderStmt->execute()) {
                throw new Exception("Error inserting header data: " . $conn->error);
            }
        }

        // Commit the transaction
        $conn->commit();

        // Close the prepared statement
        $insertHeaderStmt->close();

        echo 'success'; // Send a success response to the client
    } catch (Exception $e) {
        // Rollback the transaction on error
        $conn->rollback();

        // Output the error message
        echo 'error: ' . $e->getMessage();
    } finally {
        // Close the database connection
        $conn->close();
    }
} else {
    // Handle the case where 'invoiceData' is not provided in the POST request
    echo 'error';
}
?>
