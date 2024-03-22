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

if(isset($_GET['email'])){
    $buyer = $_GET['email'];
    $sql = "select * from address where email='$buyer'";
    $result = $conn->query($sql);
    $row= $result->fetch_assoc();
    $name = $row['name'];
    $phone = $row['phone'];
    $town = $row['town'];
    $location = $row['location'];

}
if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_GET['id'])){
    $auctionid = $_GET['id'];
    $sqlupdate = "update auctions set shipping = 'shipped' where id='$auctionid' ";
    if($conn->query($sqlupdate)===TRUE){
        echo "shipping status updated";
    }else{
        echo "something went wrong";
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ebid</title>
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<link href='https://fonts.googleapis.com/css?family=Pacifico' rel='stylesheet'>
<link href='https://fonts.googleapis.com/css?family=Roboto Mono' rel='stylesheet'>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


<link rel="icon" href="images/ebidlogo.png" type="image/x-icon">
  <link rel="shortcut icon" href="images/ebidlogo.png" type="image/x-icon">

</head>
<body>
    <div class="card shadow" style="width: 300px;margin:10px;" >
        <div class="card" >
            <div class="card-header" >
                <h4>Address</h4>
            </div>
            <div class="card-body" >
                <h5><?php echo $name ?></h5>
                <h5><?php echo $phone ?></h5>
                <h5><?php echo $town ?></h5>
                <h5><?php echo $location ?></h5>
            </div>
            <div class="card-footer" >
                <button id="itemShippedBtn" class="btn btn-primary" >item shipped</button>
            </div>
        </div>
    </div>


    <script>
    $(document).ready(function() {
        $('#itemShippedBtn').on('click', function() {
            $.ajax({
                url: '', 
                method: 'POST',
                data: { email: '<?php echo $name; ?>' }, 
                success: function(response) {
                    $('.card-footer').html('<p class="text-success">' + 'shipping status updated' + '</p>');
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        });
    });
</script>

</body>
</html>