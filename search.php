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

// check wether search query post is null or not
$searchQuery = isset($_POST['searchquery']) ? $_POST['searchquery'] : 's'; 

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
<section>
    <section class="row" >
        <div class="col-md-2" >
    <a href="/ebay/index.php"> <img src="images/ebidlogo.png" width="150px" height="70px" style="border-radius: 10px; margin-left:5px;margin-top:15px; margin-bottom:1px;" alt="" srcset=""></a>
    </div>
        <div class="col-md-6"  style="align-self: center;">
                <form action="" class="search-form" method="post" style="display: flex;" >
                    <input type="text" class="form-control" name="searchquery" style="border-color: black;margin-left:5px;"  required  placeholder="search for anything"  >
                    <button type="submit" class="btn btn-primary" style="margin-left: 10px;margin-right:10px; color:white;font-family: Roboto Mono;" >search</button>
                </form>
        </div>
    </section>
</section>
<!-- navbar -->
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


<!-- the search items -->
<section>
    <h5 style="margin: 10px;">search results</h5>
    <div class="items" style=" height: 300px;">
    <?php
// Construct the SQL query with the search query
$sqlget = "SELECT * FROM auctions WHERE name LIKE '%$searchQuery%' OR category LIKE '%$searchQuery%' OR itemdesc LIKE '%$searchQuery%'  LIMIT 5";
$resultget = $conn->query($sqlget);
$itemCount = 0;
$totalItems = $resultget->num_rows;

while ($row2 = $resultget->fetch_assoc()) {
    $elecid = $row2['id'];
    $name = $row2['name'];
    $minbid = $row2['bid'];
    $image = 'images/'.$row2['image1'];
    $itemCount++;

    // Check if the item count is less than 3
    if ($totalItems >= 3 && $itemCount >= 3) {
        $idAttribute = 'id="elexcess"'; // Assign id="elexcess" if it's among the last three
    } else {
        $idAttribute = ''; // Otherwise, don't assign the id
    }

    // populate the html tags
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



</body>
</html>