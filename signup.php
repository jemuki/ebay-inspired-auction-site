<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ebay";

// create connection to the database
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}   

$username = $_POST['username'];
$email = $_POST['email'];
$password = trim($_POST['password']); 
$hashedpass = password_hash($password, PASSWORD_DEFAULT);
$dp = "ddp.png";
$bio = "Hey there!";
$joined = date('F').' '.date("Y");
$acctype = $_POST['acctype'];
if($acctype === "pacc"){
    $sql = "INSERT INTO users (username, email, password, dp, bio, joined, payment) VALUES ('$username', '$email', '$hashedpass','$dp', '$bio', '$joined', 'your mpesa number')";  
    $sql2 = "insert into address(email, name, phone, town, location)values('$email', 'your name', 'your phone', 'your town', 'your location')" ;
    // method query, executes the passed sql value
    $conn->query($sql2);
}else{
    $sql = "INSERT INTO sellers (username, email, password, dp, bio, joined) VALUES ('$username', '$email', '$hashedpass','$dp', '$bio', '$joined')";    
}

// insert user
if ($conn->query($sql) === TRUE) { 
    session_start();
    $_SESSION['email'] = $email;
    $_SESSION['type'] = $acctype;
    $_SESSION['name'] = $username;
    $_SESSION['joined'] = $joined;
    header("Location: /ebay/index.php");
    exit();
    } else {
    echo "signup not successful: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
