<?php
include('connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['Name'];
    $mobileNo = $_POST['MobileNo'];
    $email = $_POST['EmailId'];
    $gender = $_POST['Gender'];
    $username = $_POST['UserName'];
    $password = $_POST['Password'];

    // Check if the username already exists
    $checkUser = "SELECT * FROM tblusers WHERE username = ?";
    $stmtCheckUser = $conn->prepare($checkUser);
    $stmtCheckUser->bind_param("s", $username);
    $stmtCheckUser->execute();
    $resultUser = $stmtCheckUser->get_result();

    if ($resultUser->num_rows > 0) {
        echo "User already registered. Click OK to login.";
    } else {
        $sql = "INSERT INTO tblusers (name, mobileNo, EmailId, gender, username, password, SavedDateTime) 
                VALUES (?, ?, ?, ?, ?, ?, NOW())";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssss", $name, $mobileNo, $email, $gender, $username, $password);

        if ($stmt->execute()) {
            echo "Registration successful!";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    }

    $stmtCheckUser->close();
}
?>
