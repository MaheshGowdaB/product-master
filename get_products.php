<?php
include "connection.php";

if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search_id = $_GET['search'];
    $sql = "SELECT * FROM tblproducts WHERE product_code = '$search_id'";
} else {
    $sql = "SELECT * FROM tblproducts";
}

$result = $conn->query($sql);

if (!$result) {
    die("Invalid query!");
}

// Display table headers
echo "
    <thead>
        <tr>
            <th>Product Code</th>
            <th>Product Name</th>
            <th>Unit of Measure</th>
            <th>Stock</th>
            <th>Selling Price</th>
            <th>Offer Price</th>
            <th>Product Image</th>
            <th>ACTIONS</th>
        </tr>
    </thead>
    <tbody>
";

while ($row = $result->fetch_assoc()) {
    echo "
    <tr>
        <th>{$row['product_code']}</th>
        <td>{$row['product_name']}</td>
        <td>{$row['UOM']}</td>
        <td>{$row['stock']}</td>
        <td>{$row['selling_price']}</td>
        <td>{$row['offer_price']}</td>
        <td>{$row['product_image']}</td>
        <td>
            <a class='btn btn-primary edit-product' href='#' data-bs-toggle='modal' data-bs-target='#editProductModal'
                data-id='{$row['id']}'
                data-name='{$row['product_name']}'
                data-UOM='{$row['UOM']}'
                data-stock='{$row['stock']}'
                data-selling-price='{$row['selling_price']}'
                data-offer-price='{$row['offer_price']}'
                data-product-image='{$row['product_image']}'>
                Edit
            </a>
            <a class='btn btn-danger delete-product' href='delete_product.php?id={$row['id']}' onclick=\"return confirm('Are you sure you want to delete this product?')\">Delete</a>
        </td>
    </tr>
    ";
}

echo "</tbody>";

$conn->close();
?>
