<?php
include "connection.php";

function sanitize($input)
{
    global $conn;
    return mysqli_real_escape_string($conn, trim($input));
}

if (isset($_POST['invoiceData']) && !empty($_POST['invoiceData'])) {
    $invoiceData = json_decode($_POST['invoiceData'], true);

    $totalQty = 0;

    foreach ($invoiceData as $key => $value) {
        if (strpos($key, 'qty') !== false) {
            $totalQty += $value;
        }
    }

    $sqlHead = "INSERT INTO tblinvhead (InvoiceNo, InvoiceDate, CustomerName, MobileNo, Qty, NetTotal, Saved_By, SavedDateTime)
                VALUES (
                    '" . sanitize($invoiceData['invoiceNumber']) . "',
                    '" . sanitize($invoiceData['invoiceDate']) . "',
                    '" . sanitize($invoiceData['customerName']) . "',
                    '" . sanitize($invoiceData['mobileNumber']) . "',
                    '$totalQty',
                    '" . sanitize($invoiceData['NetTotal']) . "',
                    '" . sanitize($invoiceData['Saved_By']) . "',
                    NOW()
                )";

    $resultHead = $conn->query($sqlHead);

    if (!$resultHead) {
        die("Error inserting into tblinvhead: " . $conn->error);
    }

    foreach ($invoiceData as $key => $value) {
        if (strpos($key, 'productCode') !== false) {
            $slNo = substr($key, 9);
            $productCode = sanitize($value);
            $productName = sanitize($invoiceData['productName' . $slNo]);
            $qty = sanitize($invoiceData['qty' . $slNo]);
            $sellingPrice = sanitize($invoiceData['sellingPrice' . $slNo]);
            $offerPrice = sanitize($invoiceData['offerPrice' . $slNo]);
            $total = $qty * ($offerPrice ?: $sellingPrice);

            $sqlDetail = "INSERT INTO tblinvdetail (InvoiceNo, SLNo, product_code, product_name, Qty, selling_price, offer_price, total)
                          VALUES ('" . sanitize($invoiceData['invoiceNumber']) . "', '$slNo', '$productCode', '$productName', '$qty', '$sellingPrice', '$offerPrice', '$total')";

            $resultDetail = $conn->query($sqlDetail);

            if (!$resultDetail) {
                die("Error inserting into tblinvdetail: " . $conn->error);
            }

            $sqlUpdateStock = "UPDATE tblproducts
                              SET stock = stock - '$qty'
                              WHERE product_code = '$productCode'";

            $resultUpdateStock = $conn->query($sqlUpdateStock);

            if (!$resultUpdateStock) {
                die("Error updating stock in tblproducts: " . $conn->error);
            }
        }
    }

    $conn->close();

    echo 'success'; 
} else {
    echo 'error';
}
?>
