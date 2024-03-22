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
$acctype = $_SESSION['type'];

if (!isset($email) || !isset($acctype)) {
    header("location: /ebay/signup.html");
    exit();
}

if($acctype === "pacc"){
    $profilepage = "buyerdash.php";
    $sql = "select * from users where email='$email'";
}else{
    $profilepage = "sellerdash.php";
    $sql = "select * from sellers where email='$email'";
}

$result=$conn->query($sql);
$row=$result->fetch_assoc();
$name=$row['username'];
$bio = $row['bio'];
$joined = $row['joined'];


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
/* when the screen is bigger */
@media (min-width: 768px) {
    .form-control {
        max-width: 650px; 
    }
}
/* when the screen is small */
@media screen and (max-width: 768px) {
    .search-form {
      margin-bottom: 10px; 
    }
   #bannername{
    display: none;
   }
   #elexcess{
    display: none;
   }
  }
  .thenav{
    height: 50px;
    justify-content: center;
    margin-top: 10px;
  }
  .items{
    display: flex;
   
  }
  .card {
    width: 350px !important; /* Maintain a fixed width for each card */
    margin-left: 5px;
}

  </style>

</head>
<body>

</div>
    <!-- the header -->
    <section>
    <section class="row d-flex align-items-center" >
        <div class="col-md-2 d-flex align-items-center" >
                <img src="images/ebidlogo.png" width="150px" height="70px" style="border-radius: 10px; margin-left:5px;margin-top:15px; margin-bottom:1px;" alt="" srcset="">
        </div>
        <div class="col-md-6    "  style="align-self: center;">
                <form action="/ebay/search.php" method="post"  class="search-form" style="display: flex;" >
                    <input type="text" class="form-control" style="border-color: black;margin-left:5px;" name="searchquery"  required  placeholder="search for anything"  >
                    <button type="submit" class="btn btn-primary" style="margin-left: 10px;margin-right:10px; color:white;font-family: Roboto Mono;" >search</button>
                </form>
        </div>
        <!-- to profile -->
        <div class="col-md-3 " style="align-self: center;margin-left:5px;display:flex;" >
        <a href="<?php echo $profilepage ?>" style="text-decoration: none;color:black;" > 
        <div style="display: flex; background-color:#f5f5f5;border-radius:5px;padding:8px;" >
        <img src="images/user (1).png" width="25px" height="25px" style="margin-right: 10px;"  alt="" srcset="">
      <h6 ><b>Hi, <?php echo $name ?></b></h6> 
    </div>
      </a>
           <!--logout  -->
           <div class="" style="align-self: center;margin-left:10px;display:flex;" >
        <a href="signup.html" style="text-decoration: none;color:black;" > 
        <div style="display: flex; background-color:#f5f5f5;border-radius:5px;padding:8px;" >
      <h6 ><b>Logout</b></h6> 
    </div>
      </a>
          </div>  

          </div> 
         
    </section>
</section>
   
    <!--the navbar  -->
    <section>
<div class="thenav" style="display: flex;">
    <a href="/ebay/index.php"  style="color: black;">Home</a>
    <form id="categoryForm" method="post" action="">
        <button type="button" onclick="submitCategory('electronics', 'searchquery');" style="margin-left: 10px; color: black; border: none; background: none; cursor: pointer;">Electronic</button>
        <button type="button" onclick="submitCategory('fashion', 'searchquery');" style="margin-left: 10px; color: black; border: none; background: none; cursor: pointer;">Fashion</button>
        <button type="button" onclick="submitCategory('sports', 'searchquery');" style="margin-left: 10px; color: black; border: none; background: none; cursor: pointer;">Sports</button>
        <button type="button" onclick="submitCategory('home & garden', 'searchquery');" style="margin-left: 10px; color: black; border: none; background: none; cursor: pointer;">Home & Garden</button>
        <button type="button" onclick="submitCategory('collectibles', 'searchquery');" style="margin-left: 10px; color: black; border: none; background: none; cursor: pointer;">Collectibles</button>
        <input type="hidden" name="searchquery" id="categoryInput" value="">
    </form>

</div>
<script>
 function submitCategory(category) {
    document.querySelector('.search-form input[name="searchquery"]').value = category;
    }
</script>
</section>

<!-- the banner -->
<section>
    <div class="thecar" style="height: 330px;" >
        <div id="carouselExampleControls" style="margin: top 10px;" class="carousel slide" data-ride="carousel" data-interval="2000">
            <div class="carousel-inner">
                <!-- first item -->
              <div class="carousel-item active">
                <div class="row " style="background-color: #fccd25;" >
                    <div class="col-md-4 " id="bannername" >
                            <h2 style="margin: 40px;" >it's Pokemon Day - get'em all!</h2>
                            <p style="margin: 40px;font-size:large;" >Complete your collection with new, valuable, hard to find...</p>
                            <button class="btn btn-outline-dark" style="border-radius: 50px; margin-left:40px;font-size:large;" >Explore</button>
                    </div>
                    <div class="col-md-8" >
                        <img class="d-block w-100"  height="330px" src="https://i.ebayimg.com/00/s/NTgxWDE2MDA=/z/lW4AAOSw5c5lxK1o/$_57.JPG" alt="First slide">
                    </div>
                </div>
              </div>
            <!-- second item -->
              <div class="carousel-item">
                <div class="row " style="background-color: #fccd25;" >
                    <div class="col-md-4 " id="bannername" >
                            <h2 style="margin: 40px;" >Discover a kaleidoscope of cards</h2>
                            <p style="margin: 40px;font-size:large;" >Build your collection of trading cards and collectible card games</p>
                            <button class="btn btn-outline-dark" style="border-radius: 50px; margin-left:40px;font-size:large;" >Explore</button>
                    </div>
                    <div class="col-md-8" >
                        <img class="d-block w-100"  height="330px" src="https://i.ebayimg.com/images/g/jfYAAOSw6rhlbyzM/s-l960.webp" alt="First slide">
                    </div>
                </div>
                  
              </div>
              <!-- <div class="carousel-item">
                <img class="d-block w-100" height="330px" src="https://i.ebayimg.com/00/s/NTgxWDE2MDA=/z/lW4AAOSw5c5lxK1o/$_57.JPG" alt="Third slide">
              </div> -->
            </div>
          </div>
    </div>
</section>

<!-- categories -->
<section>
    <h4 style="margin-left: 5px;">Categories</h4>
    <h5 style="margin: 10px;">Electronics</h5>
    <div class="items" style=" height: 300px;">
    <?php
$sqlget = "SELECT * FROM auctions WHERE category = 'electronics' ORDER BY RAND() LIMIT 5";
$resultget = $conn->query($sqlget);
$itemCount = 0;
$totalItems = $resultget->num_rows;
while ($row2 = $resultget->fetch_assoc()) {
    $elecid = $row2['id'];
    $name = $row2['name'];
    $minbid = $row2['bid'];
    $image = 'images/'.$row2['image1'];
    $itemCount++;
    $isLastThree = $totalItems - $itemCount < 3; // Check if the item is among the last three
    $idAttribute = $isLastThree ? 'id="elexcess"' : ''; // Assign id if it's among the last three
    echo '<div class="card shadow" style="height: 350px; margin-left: 5px;" ' . $idAttribute . '>';
    echo '<div class="card-body">';
    echo '<img src="' . $image . '" style="width: 100%;" height="200px" alt="">';
    echo '<p class="text-dark">' . $name . '</p>';
    echo '<h4 class="text-dark">Ksh ' . $minbid . '</h4>';
    echo '<a href="/ebay/product.php?product_id='.$elecid.'" style="text-decoration:none;color:black;" ><u class="text-danger" >view item</u></a>';
    echo '</div>';
    echo '</div>';
    
}
?>

    </div>
</section>

<!-- others -->
<br><br>
<section>
    <h5 style="margin: 10px;">Others</h5>
    <div class="items" style="width: 100%; height: 300px; display: flex;">
            <?php
        $sqlget = "SELECT * FROM auctions WHERE category != 'electronics' ORDER BY RAND() LIMIT 5";
        $resultget = $conn->query($sqlget);
        $itemCount = 0;
        $totalItems = $resultget->num_rows;
        while ($row2 = $resultget->fetch_assoc()) {
            $itemid = $row2['id'];
            $name = $row2['name'];
            $minbid = $row2['bid'];
            $image = 'images/'.$row2['image1'];
            $itemCount++;
            $isLastThree = $totalItems - $itemCount < 3; // Check if the item is among the last three
            $idAttribute = $isLastThree ? 'id="elexcess"' : ''; // Assign id if it's among the last three
            echo '<div class="card shadow" style="height: 350px; margin-left: 5px;" ' . $idAttribute . '>';
            echo '<div class="card-body">';
            echo '<img src="' . $image . '" style="width: 100%;" height="200px" alt="">';
            echo '<p class="text-dark">' . $name . '</p>';
            echo '<h4 class="text-dark">Ksh ' . $minbid . '</h4>';
            echo '<a href="/ebay/product.php?product_id='.$itemid.'" style="text-decoration:none;color:black;" ><u class="text-danger" >view item</u></a>';
            echo '</div>';
            echo '</div>';
        }
        ?>

    </div>
</section>



</body>
</html>