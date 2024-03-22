<?php
// Retrieve the JSON payload sent by M-Pesa
$callbackJSONData = file_get_contents('php://input');

// Decode the JSON payload
$callbackData = json_decode($callbackJSONData, true);

// Log the callback data (you might want to save this to a database)
file_put_contents('mpesa_callback.log', $callbackJSONData);

// Check if the callback data is not empty and contains the expected fields
if (!empty($callbackData) && isset($callbackData['Body'])) {
    // Extract the relevant data from the callback
    $transactionID = $callbackData['Body']['stkCallback']['CheckoutRequestID'];
    $resultCode = $callbackData['Body']['stkCallback']['ResultCode'];
    $resultDesc = $callbackData['Body']['stkCallback']['ResultDesc'];
    // You can extract other relevant data as needed

    // Process the callback based on the result code
    if ($resultCode == 0) {
        // Payment successful, update your database or perform other actions
        echo "Payment received successfully for transaction ID: $transactionID";

        // Add payment information to your database
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

        // Prepare SQL statement
        $sql = "INSERT INTO payments (transaction_id, result_code, result_desc)
                VALUES ('$transactionID', '$resultCode', '$resultDesc')";

        // Execute SQL statement
        if ($conn->query($sql) === TRUE) {
            echo "Payment information added to the database successfully";
        } else {
            echo "Error adding payment information to the database: " . $conn->error;
        }

        // Close connection
        $conn->close();
    } else {
        // Payment failed, handle accordingly
        echo "Payment failed for transaction ID: $transactionID. Result Code: $resultCode. Result Description: $resultDesc";
    }
} else {
    // Invalid callback data
    echo "Invalid callback data received";
}
?>
