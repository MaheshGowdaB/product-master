// Assume this is get_column_names.php
include "connection.php";

$tableName = "tblproducts"; // Adjust the table name as needed

$sql = "SHOW COLUMNS FROM $tableName";
$result = $conn->query($sql);

$columnNames = array();

while ($row = $result->fetch_assoc()) {
    $columnNames[] = $row['Field'];
}

$conn->close();

header('Content-Type: application/json');
echo json_encode($columnNames);
