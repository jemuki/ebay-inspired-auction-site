<?php
// Include database connection code if not already included
// Include database connection code if not already included
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ebay";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}   

// Check if the product ID is provided
if (isset($_GET['id'])) {
    $productId = $_GET['id'];

    // Perform the deletion
    $sql = "DELETE FROM auctions WHERE id = $productId";
    if ($conn->query($sql) === TRUE) {
        // Deletion successful
        echo json_encode(['success' => true]);
        exit();
    } else {
        // Error in deletion
        echo json_encode(['success' => false, 'message' => 'Error deleting product']);
        exit();
    }
} else {
    // Product ID not provided
    echo json_encode(['success' => false, 'message' => 'Product ID not provided']);
    exit();
}
?>
