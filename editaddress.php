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
$email = $_SESSION['email'];
$name = $_POST['name'];
$phone = $_POST['phone'];
$town= $_POST['town'];
$location = $_POST['location'];

$sql = "update address set name='$name', phone='$phone', town='$town', location='$location' where email='$email' ";
if($conn->query($sql)=== TRUE){
    echo "address updated successfully";
    header("location: /ebay/buyerdash.php");
    exit();
}else{
    echo "something went wrong";
}
$conn->close();

?>