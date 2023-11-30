<?php
include "connection.php";

// Function to sanitize input data
function sanitize($input)
{
    global $conn;
    return mysqli_real_escape_string($conn, trim($input));
}

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

    $sqlHead = "INSERT INTO tblinvhead (InvoiceNo, InvoiceDate, CustomerName, MobileNo, Qty, NetTotal, Saved_By, SavedDateTime)
                VALUES (
                    '" . sanitize($firstRowData['invoiceNo']) . "',
                    '" . sanitize($firstRowData['invoiceDate']) . "',
                    '" . sanitize($firstRowData['customerName']) . "',
                    '" . sanitize($firstRowData['mobileNo']) . "',
                    '$totalQty',
                    '" . sanitize($firstRowData['netTotal']) . "',
                    '" . sanitize($firstRowData['savedBy']) . "',
                    '" . sanitize($firstRowData['savedDateTime']) . "'
                )";

    $resultHead = $conn->query($sqlHead);

    if (!$resultHead) {
        die("Invalid query: " . $conn->error);
    }

    // Update stock in tblproducts for each product code
    foreach ($invoiceData as $rowData) {
        $productCode = sanitize($rowData['productCode']);
        $qty = sanitize($rowData['qty']);

        $updateStockSql = "UPDATE tblproducts SET stock = stock - '$qty' WHERE product_code = '$productCode'";
        $updateStockResult = $conn->query($updateStockSql);

        if (!$updateStockResult) {
            die("Invalid query: " . $conn->error);
        }
    }

    // Iterate through each row's data and insert into tblinvdetail
    foreach ($invoiceData as $rowData) {
        $invoiceNo = sanitize($rowData['invoiceNo']);
        $slNo = sanitize($rowData['slNo']);
        $productCode = sanitize($rowData['productCode']);
        $productName = sanitize($rowData['productName']);
        $qty = sanitize($rowData['qty']);
        $sellingPrice = sanitize($rowData['sellingPrice']);
        $offerPrice = sanitize($rowData['offerPrice']);
        $total = sanitize($rowData['total']);

        $sqlDetail = "INSERT INTO tblinvdetail (InvoiceNo, SLNo, product_code, product_name, Qty, selling_price, offer_price, total)
                      VALUES ('$invoiceNo', '$slNo', '$productCode', '$productName', '$qty', '$sellingPrice', '$offerPrice', '$total')";

        $resultDetail = $conn->query($sqlDetail);

        if (!$resultDetail) {
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
