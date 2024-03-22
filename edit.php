<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ebay";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}   

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file']) && $_FILES['file']['error'] !== UPLOAD_ERR_NO_FILE) {
    $targetDir = "images/";
    $uploadedFileName = $_FILES['file']['name'];
    $fileExtension = pathinfo($uploadedFileName, PATHINFO_EXTENSION);

    // Generate a unique name for the image
    $randomName = uniqid('', true);
    $newFileName = $randomName . '.' . $fileExtension;
    $targetFile = $targetDir . $newFileName;

    $check = getimagesize($_FILES['file']['tmp_name']);

    if ($check !== false) {
        if (move_uploaded_file($_FILES['file']['tmp_name'], $targetFile)) {
            // Update the database with the new filename
            $userEmail2 = $_SESSION['email'];
            $sqldp = "UPDATE sellers SET dp='$newFileName' WHERE email='$userEmail2'";

            if ($conn->query($sqldp) === TRUE) {
        
            } else {
                echo "Error updating database: " . $conn->error;
            }
        } else {
            echo "Error uploading file.";
        }
    } else {
        echo "File is not an image.";
    }
}

$username = $_POST['username'];
$bio = $_POST['bio'];

$userEmail = $_SESSION['email'];

$updateFields = array();

if (!empty($username)) {
    $updateFields[] = "username = '$username'";
}

if (!empty($bio)) {
    $updateFields[] = "bio = '$bio'";
}


if (!empty($updateFields)) {
    $updateQuery = "UPDATE sellers SET " . implode(", ", $updateFields);

    $updateQuery .= " WHERE email = '$userEmail'";

    if ($conn->query($updateQuery) === TRUE) { 
        header("Location: /ebay/sellerdash.php");
        exit();
    } else {
        echo "Something went wrong:" . $sql . "<br>" . $conn->error;
    }
} else {
    //no fields
    header("Location: /ebay/sellerdash.php");
    exit();
}



$conn->close();
?>