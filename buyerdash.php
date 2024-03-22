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
$sql = "select * from users where email='$email' ";
$result=$conn->query($sql);
$row=$result->fetch_assoc();
$name = $row['username'];
$bio = $row['bio'];
$dp = $row['dp'];
$joined = $row['joined'];
$mpesanum = $row['payment'];

// get user addresses
$sql2 = "select * from address where email='$email'";
$result2 = $conn->query($sql2);
$row2 = $result2->fetch_assoc();
$addressname = $row2['name'];
$addressphone = $row2['phone'];
$town = $row2['town'];
$location = $row2['location'];

//edit the mpesa number
if($_SERVER['REQUEST_METHOD'] === 'POST'){
  if(isset($_POST['mpesanum'])){
    $mnum = $_POST['mpesanum'];
    $sql3 = "update users set payment='$mnum' where email='$email' ";
    if($conn->query($sql3) === TRUE){
      header("location: /ebay/buyerdash.php");
      exit();
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
     
.row{
    min-height: 50px;
    
}    
.search-form {
    display: flex;
    align-items: center;
  }

.form-control {
    width: 100%;
}

@media (min-width: 768px) {
    .form-control {
        max-width: 650px; 
    }
}
@media screen and (max-width: 768px) {
    .search-form {
      margin-bottom: 10px; 
    }
    .card{
        margin-top: 10px;
        margin-left: 10px;
    }
  }
  
  .username{
    height: 120px;
    display: flex;
    padding: 10px;
    background-color: #f5f5f5;

  }
  .theitem{
    height: 150px;
    display: flex;
    padding: 10px;
    background-color: #f5f5f5;
    margin-bottom: 10px;
  }
</style>

</head>
<body>
    <!-- the header -->
    <section>
    <section class="row" >
    <div class="col-md-2 d-flex align-items-center" >
    <a href="/ebay/index.php"> <img src="images/ebidlogo.png" width="150px" height="70px" style="border-radius: 10px; margin-left:5px;margin-top:15px; margin-bottom:1px;" alt="" srcset=""></a>
        </div>
        <div class="col-md-6"  style="align-self: center;">
                <form action="/ebay/search.php" method="post"  class="search-form" style="display: flex;" >
                    <input type="text" class="form-control" style="border-color: black;margin-left:5px;" name="searchquery"  required  placeholder="search for anything"  >
                    <button type="submit" class="btn btn-primary" style="margin-left: 10px;margin-right:10px; color:white;font-family: Roboto Mono;" >search</button>
                </form>
        </div>
       
       </section>
</section>

<!-- user details -->
<section>
    <div class="username" >
        <img src="images/<?php echo $dp ?>" width="100px" height="100px" style="border-radius: 50%;" alt="">
        <div style="margin-left: 20px;align-self:center;" >
            <h4> <?php echo $name ?></h4>
            <span><?php echo $bio ?></span><br>
            <span>joined <?php echo $joined ?></span>
        </div>
    </div>
</section>

<!-- account detail -->
<br>
<section>
<div class="row" >
    <!-- details -->
    <div class="col-md-3" >
        <div class="card" style="height: 230px;margin-left:10px;" >
            <div class="card-header" >
            <h5>Account details</h5>
            </div>
            <div class="card-body" >
                <span ><?php echo $name ?></span><br>
                <span> <?php echo $email ?> </span>
                <br>
               <a href="" style="text-decoration: none;" data-toggle="modal" data-target="#editprofilemodal" id="editprofile" > <u class="text-danger" >edit</u></a>
                </div>
            </div>

            <!-- edit profile modal -->
         <div class="modal fade" id="editprofilemodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Edit profile</h5>
              </div>
              <div class="modal-body d-flex flex-column justify-content-center align-items-center">
                <div class="hey d-flex flex-column justify-content-center align-items-center">
                 <!--the form  -->
                <form action="/ebay/editbuyer.php" method="post" enctype="multipart/form-data" >
                    <input type="text" placeholder="username" name="username" class="form-control">
                     <textarea   style="margin-top: 5px;" name="bio" placeholder="bio" class="form-control"  cols="30" rows="2"></textarea>
                     <p>profile picture:</p>
                    <input type="file" name="file" accept="image/*" placeholder="dp" >
                    <input type="submit" class="btn " style="background-color: #FFAA33;color:white; " value="submit" >
                  </form>  
                 </div>
            </div>
            </div>
          </div>
        </div>
    
    </div>
<!-- address -->
    <div class="col-md-3" >
        <div class="card" style="height: 230px;">
            <div class="card-header" >
            <h5>Address</h5>
            </div>
            <div class="card-body" >
                <span > <?php echo $addressname ?></span><br>
                <span><?php echo $addressphone ?></span><br>
                <span><?php echo $town ?></span><br>
                <span><?php echo $location ?></span>
                <br>
               <a href="" data-toggle="modal" data-target="#editaddressmodal"  style="text-decoration: none;" > <u class="text-danger" >edit</u></a>
                </div>
            </div>


 
            <!-- edit adddress -->
        <div class="modal fade" id="editaddressmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Edit your address</h5>
              </div>
              <div class="modal-body d-flex flex-column justify-content-center align-items-center">
                <div class="hey d-flex flex-column justify-content-center align-items-center">
                  <form action="/ebay/editaddress.php" method="post" >
                    <input type="text" placeholder="enter your name" name="name" required class="form-control"><br>
                    <input type="text" placeholder="enter your phone" name="phone" required class="form-control"><br>
                    <input type=" text" class="form-control" name="town" required placeholder="enter your town"><br>
                    <input type="text" class="form-control" name="location" required placeholder="enter your precise location"><br>
                    <input type="submit" value="submit" class="btn btn-warning">
                </form>  
                 </div>
            </div>
            </div>
          </div>
        </div>
    
    </div>
<!-- payment details -->
<div class="col-md-3" >
    <div class="card" style="height: 230px;">
        <div class="card-header" >
        <h5>Payment info</h5>
        </div>
        <div class="card-body" >
            <h5 >Mpesa number</h5>
            <span><?php echo $mpesanum ?></span>
            <br>
           <a href="" data-toggle="modal" data-target="#editmpesamodal"style="text-decoration: none;" > <u class="text-danger" >edit</u></a>
            </div>

                 <!-- edit mpesa number -->
        <div class="modal fade" id="editmpesamodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Edit mpesa number</h5>
              </div>
              <div class="modal-body d-flex flex-column justify-content-center align-items-center">
                <div class="hey d-flex flex-column justify-content-center align-items-center">
                  <form action="" method="post" >
                    <input type="text" placeholder="mpesa phone number" value="2547" name="mpesanum" class="form-control"><br>
                    <input type="submit" value="submit" class="btn btn-warning">
                </form>  
                 </div>
            </div>
            </div>
          </div>
        </div>
    
        </div>
</div>
</div>    
</section> 

<!-- Live auctions -->
<section style="margin-left: 10px;" >
    <h5>Live auctions</h5>
    <div class="liveauctions" >
    <?php
        //get your live auctions
        $sql4 = "SELECT * FROM auctions WHERE bidder='$email'";
        $result4 = $conn->query($sql4);
        $modalCount = 0; // Counter for unique modal IDs
        while ($row4 = $result4->fetch_assoc()) {
            $id = $row4['id'];
            $image = 'images/' . $row4['image1'];
            $name = $row4['name'];
            $yourbid = $row4['currentbid'];
            $expiry = strtotime($row4['expiry']);
            $expiryshow = 'Exp: ' . $row4['expiry'];

            // Generate unique modal ID
            $modalId = 'paymodal' . $modalCount;
            $modalCount++;

            echo '<div class="theitem">';
            echo '<img src="' . $image . '" width="130px" height="130px"  alt="" srcset="">';
            echo '<div style="margin-left: 20px;align-self:center;">';
            echo '<h5>' . $name . '</h5>';
            echo '<h6 style="font-weight: normal;">Your bid: <u>Ksh ' . $yourbid . '</u></h6>';
            if ($expiry >= time()) {
                echo '<h6 class="text-danger" style="font-weight: normal;">Exp: ' . date('Y-m-d H:i:s', $expiry) . '</h6>'; // Display expiry date
            } else {
              echo '<h6 class="text-danger" style="font-weight: normal;">you won! <a href="#" onclick="payWithMpesa(\'' . $id . '\', \'' . $yourbid . '\', \'' . $mpesanum . '\')" style="color:black;" >pay</a> </h6>';
            }

            echo '<a href="/ebay/product.php?product_id=' . $id . '" style="text-decoration: none;"><h6 class="text-danger" style="font-weight: normal;"><u>View product</u></h6></a>';
            echo '</div>';
            echo '</div>';
           
        }
        ?>

<script>
function payWithMpesa(id, bid, mpesanum) {
    var form = document.createElement('form');
    form.method = 'post';
    form.action = '/ebay/mpesa.php';
    
    var inputId = document.createElement('input');
    inputId.type = 'hidden';
    inputId.name = 'id';
    inputId.value = id;
    
    var inputBid = document.createElement('input');
    inputBid.type = 'hidden';
    inputBid.name = 'bid';
    inputBid.value = bid;

    var inputMpesaNum = document.createElement('input');
    inputMpesaNum.type = 'hidden';
    inputMpesaNum.name = 'mpesanum';
    inputMpesaNum.value = mpesanum;
    
    form.appendChild(inputId);
    form.appendChild(inputBid);
    form.appendChild(inputMpesaNum);
    
    document.body.appendChild(form);
    
    form.submit();
}
</script>
</div>
</section>
</body>
</html>
