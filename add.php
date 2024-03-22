<?php
session_start(); // Start the session if not already started

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ebay";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}   

function uploadimage($theimage){
    $targetDir = "images/";
    $uploadedFileName = $theimage['name'];
    $fileExtension = pathinfo($uploadedFileName, PATHINFO_EXTENSION);

    // Check for file upload errors
    if ($theimage['error'] !== UPLOAD_ERR_OK) {
        echo "File upload failed with error code: " . $theimage['error'];
        return false;
    }

    // Generate a unique name for the image
    $randomName = uniqid('', true);
    $newFileName = $randomName . '.' . $fileExtension;
    $targetFile = $targetDir . $newFileName;

    // Move the uploaded file to the target directory
    if (move_uploaded_file($theimage['tmp_name'], $targetFile)) {
        return $newFileName; // Return the generated filename
    } else {
        echo "Failed to move uploaded file to destination directory.";
        return false; // Return false if the upload fails
    }
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_SESSION['email'];
    $name = $_POST['name'];
    $category = $_POST['category'];
    $itemdesc = $_POST['itemdesc'];
    $delinfo = $_POST['delinfo'];
    $retinfo = $_POST['retinfo'];
    $price = $_POST['price'];
    $date = $_POST['date'];
    $image1 = uploadimage($_FILES['image1']);
    $image2 = uploadimage($_FILES['image2']);
    $image3 = uploadimage($_FILES['image3']);
    $status = "on";
  
    $sql = "INSERT INTO auctions (email, name, category, itemdesc, delivery, returninfo, bid, expiry, image1, image2, image3, status)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    // Prepare the statement
    $stmt = $conn->prepare($sql);

    // Bind parameters
    $stmt->bind_param("ssssssssssss", $email, $name,$category, $itemdesc, $delinfo, $retinfo, $price, $date, $image1, $image2, $image3, $status);

    // Execute the statement
    if ($stmt->execute()) {
    echo "Item details inserted successfully.";
    header("location: sellerdash.php");
    exit();
    } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close statement
    $stmt->close();
    }

// Close connection
$conn->close();
?>
