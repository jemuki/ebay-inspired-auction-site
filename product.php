<?php
// get product id
if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];
   
} 
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
$sql = "SELECT * FROM auctions WHERE id ='$product_id'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$itemName = $row['name'];
$seller = $row['email'];
$itemdesc = $row['itemdesc'];
$delinfo = $row['delivery'];
$retinfo = $row['returninfo'];
$exp = $row['expiry'];
$minBid = $row['bid'];
$currentBid = $row['currentbid'];
$image1 = "images/" . $row['image1']; 
$image2 = "images/" . $row['image2']; 
$image3 = "images/" . $row['image3']; 

$sql2 = "select * from sellers where email = '$seller'";
$result2 = $conn->query($sql2);
$row2 = $result2->fetch_assoc();
$shopname = $row2['username'];
if($row2['blocked']==="blocked"){
    $blocked = "yes";
}else{
    $blocked = "no";
}

// update auction status 
if (strtotime($exp) < time()) {
    // Update the status of the auction to "off"
    $updatestatussql = "UPDATE auctions SET status = 'off' WHERE id = $product_id";
    $conn->query($updatestatussql);
}

// add your bid
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(isset($_POST['placebid'])){
        // Get the posted bid amount
    $placebid = $_POST['placebid'];

    // Check if the posted bid is greater than the minimum bid and the current bid
    if ($placebid > $minBid && $placebid > $currentBid) {
        // Update the current bid in the database
        $update_sql = "UPDATE auctions SET currentbid = $placebid, bidder='$email' WHERE id = $product_id";
        if ($conn->query($update_sql) === TRUE) {
            header("location: /ebay/product.php?product_id=$product_id");
            exit();
        } else {
            echo "Error updating bid: " . $conn->error;
        }
    } else {
        echo "Bid amount should be greater than the minimum bid and the current bid.";
    }

    }
}

// add a review/comment
//get their username
$acctype = $_SESSION['type'];
if($acctype === "pacc"){
    $sqlgetuser = "SELECT * FROM users WHERE email = '$email'";
}else{
    $sqlgetuser = "SELECT * FROM sellers WHERE email = '$email'";
}
$result = $conn->query($sqlgetuser);
$row3 = $result->fetch_assoc();
$username = $row3['username'];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if(isset($_POST['thereview'])){
    $thereview = $_POST['thereview'];
    $sqlreview = "insert into reviews(product_id, username, review) values('$product_id', '$username', '$thereview')";
    if ($conn->query($sqlreview) === TRUE) {
        header("location: /ebay/product.php?product_id=$product_id");
        exit();
    }else{
        echo "something went wrong!";
    }
  }
}


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


<link rel="icon" href="images/ebidlogo.png" type="image/x-icon">
  <link rel="shortcut icon" href="images/ebidlogo.png" type="image/x-icon">

  <style>
    .leftimages{
        border-radius: 10px;
    }
.carousel-control-prev-icon,
.carousel-control-next-icon {
    background-color: #fccd25; 
    color: #fccd25; 
}

.carousel-control-prev-icon,
.carousel-control-next-icon {
    width: 30px;
    height: 30px; 
}
.col{
    height: 400px;
    justify-content: center;
    align-items: center;
}

  </style>

</head>
<body>
    <br>
              
    <div class="row" >
        <div class="col-md-4" style="background-color: #f5f5f5;border-radius:10px;padding:10px;margin-left:10px;" >
            <div id="carouselExampleControls" class="carousel slide" style="align-self: center;" data-ride="carousel">
                <div class="carousel-inner">
                  <div class="carousel-item active">
                    <img width="100%" height="400px" src="<?php echo $image1; ?>" alt="Picture 1 of 4">
                </div>
                  <div class="carousel-item">
                    <img width="100%" height="400px" src="<?php echo $image2; ?>" alt="Picture 2 of 4">
                </div>
                  <div class="carousel-item">
                    <img width="100%" height="400px" src="<?php echo $image3; ?>" alt="Picture 4 of 4">
                </div>
                </div>
                <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                  <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                  <span class="carousel-control-next-icon" aria-hidden="true"></span>
                  <span class="sr-only">Next</span>
                </a>
              </div>
              </div>

              <div class="col-md-4" style="margin-left: 10px;" >
            <a href="#" style="text-decoration: none;" > <h4 class="text-dark" ><u><?php echo $shopname; ?></u></h4></a>
            <h5 class="text-dark" ><?php echo $itemName; ?></h5>
            <p class="text-dark" style="font-size: 20px;" ><?php echo $itemdesc; ?></p> 
            <h5 style="font-weight: normal;" ><?php echo $delinfo; ?></h5>
            <h5 style="font-weight: normal;"><?php echo $retinfo; ?></h5>
            <h5 style="font-weight: normal;">minimum bid: Ksh <?php echo $minBid; ?></h5>
            <h5 style="font-weight: normal;">highest bid: Ksh <?php echo $currentBid; ?></h5>
            <h5 style="font-weight: normal;" class="text-danger" >Exp: <?php echo $exp; ?></h5>
            <?php if (strtotime($exp) >= time()): ?>
            <?php if ($blocked === "yes"): ?>
            <p class="text-danger" >seller account suspended</p>
            <?php else: ?>
                <form action="" method="post">
                    <input type="number" name="placebid" placeholder="place your bid" class="form-control">
                    <button type="submit"  class="btn btn-warning" style="border-radius: 10px; width: 100px;margin-top:10px;color:white;" >bid</button>
                </form>
            <?php endif; ?>

        <?php endif; ?>
        </div>
    </div>


<!-- feedback and reviews -->

<section class="row" style="margin-left: 5px;">
    <div class="col-md-8" >
        <div class="review" >
            <h5>Reviews & Comments</h5>
            <div class="thecom" >
            <?php
            $sqlgetfeed = "SELECT * FROM reviews WHERE product_id ='$product_id'";
            $result = $conn->query($sqlgetfeed);

            // Generate HTML for each item
            while ($row = $result->fetch_assoc()) {
                echo '<h6>'. $row['username'].'</h6>';
                echo '<p>'.$row['review'].'</p>';    
            }
            $conn->close();
            ?>
                </div>
            <div class="addcomm" >
                <form action="" method="post" style="display: flex;">
                    <textarea name="thereview" id="" style="width: 300px; margin-right:10px;" cols="20" rows="2" placeholder="add a review" class="form-control"></textarea>
                    <input type="submit" class="btn btn-warning" style="color:white; border: radius 10px; " value="submit" >
                </form>
            </div>
        </div>
    </div>
</section>

<br>
</body>
</html>