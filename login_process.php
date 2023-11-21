<?php
include('connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['UserName'];
    $password = $_POST['Password'];

    $sql = "SELECT COUNT(*) as count FROM tblusers WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($sql);

    // Check if a row is returned, indicating a successful login
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $loginCount = $row['count'];

        // Return 1 for success, 0 for failure
        echo $loginCount > 0 ? 1 : 0;
    } else {
        // Return 0 for failure
        echo 0;
    }
}
?>