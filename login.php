<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ebay";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}   

$email = $_POST['email'];
$password = trim($_POST['password']); 
$acctype = $_POST['acctype'];
if($acctype === "pacc"){
    $sql = "SELECT * FROM users WHERE email='$email'  ";
}else{
    $sql = "SELECT * FROM sellers WHERE email='$email'  ";
}
// query sql 
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $hashed = trim($row['password']);
    if(password_verify($password, $hashed)){
        session_start();
        $_SESSION['email'] = $row['email'];
        $_SESSION['type'] = $acctype;
        $_SESSION['name'] = $row['username'];
        header("Location: /ebay/index.php");
        exit();
    }else{
        echo "wrong details, please try again!";
    }
    
}else{
    echo "Account not found";
}


$conn->close();
?>
