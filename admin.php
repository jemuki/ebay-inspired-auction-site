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

// get or search sellers
if(isset($_POST['searchseller'])){
    $searchseller = $_POST['searchseller'];
}else{
$searchseller  = '';
}

// block a seller
if(isset($_GET['sellerid'])){
    $sellerid = $_GET['sellerid'];
    $sqlblock = "update sellers set blocked='blocked' where id='$sellerid' ";
    if($conn->query($sqlblock)===TRUE){
        echo "account blocked successfully";
    }else{
        echo "something went wrong!";
    }
  
}

// unblock seller
if(isset($_GET['sellerid2'])){
    $sellerid = $_GET['sellerid2'];
    $sqlblock = "update sellers set blocked='' where id='$sellerid' ";
    if($conn->query($sqlblock)===TRUE){
        echo "account unblocked successfully";
    }else{
        echo "something went wrong!";
    }
  
}

if(isset($_POST['searchitem'])){
    $searchitem = $_POST['searchitem'];
}else{
$searchitem  = '';
}

// delete an item
if(isset($_GET['delid'])){
    $delid = $_GET['delid'];
    $sqldel = "delete from auctions where id='$delid'";
    if($conn->query($sqldel)===True){
        echo "item deleted successfully";
    }else{
        echo "something went wrong";
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
    body{
        background-color: #f5f5f5;
    }
    .theseller{
        display: flex;
        height: 120px;
        margin-left: 10px;
        align-self: center;
       
    }
    .thenav{
        display: flex;
        justify-content: center;
    }
    .theitem{
        display: flex;
        height: 150px;
        margin-left: 10px;
        align-self: center;
    }
    .search-form{
        width: 400px;
    }
    
   </style>
</head>
<body>
    <section class="row d-flex align-items-center" >
        <div class="col-md-2 d-flex align-items-center" >
                <img src="images/ebidlogo.png" width="150px" height="70px" style="border-radius: 10px; margin-left:5px;margin-top:15px; margin-bottom:1px;" alt="" srcset="">
        </div>
          
    </section>

    <!-- the navbar -->
    <section class="thenav" >
    <a href="#sellers"><h5 style="font-weight: normal;" ><u>sellers</u></h5></a>
    <a href="#products" style="margin-left: 5px;" ><h5 style="font-weight: normal;" ><u>products</u></h5></a>

    </section>

<!-- sellers -->
<section id="sellers" >
    <h4 class="" style="margin-left:10px;" >sellers</h4>
    <form action="" method="post"  class="search-form" style="display: flex;" >
        <input type="text" class="form-control" style="border-color: black;margin-left:5px;" name="searchseller"    placeholder="search for sellers"  >
        <button type="submit" class="btn btn-primary" style="margin-left: 10px;margin-right:10px; color:white;font-family: Roboto Mono;" >search</button>
    </form>
    <br>
    <?php
    $sql = "select * from sellers where username like '%$searchseller%' or email like '%$searchseller%' or bio like '%$searchseller%' ";
    $result = $conn->query($sql);
    while( $row= $result->fetch_assoc()){
    $id = $row['id'];
    $name = $row['username'];
    $dp = $row['dp'];
    $bio = $row['bio'];
    if($row['blocked']==="blocked"){
        $blocked = "account blocked";
    }else{
        $blocked = "account active";
    }
    echo ' <div class="theseller" >';
    echo ' <img src="images/'.$dp.'" width="120x" height="120px" style="border-radius:10px;" alt="profile picture" srcset="">';
    echo '<div  class="info" style="margin-left: 10px;">';  
    echo '  <h4 style="font-weight: normal;" >'.$name.'</h4>';    
    echo ' <h5 style="font-weight: normal;">'.$bio.'</h5>';      
    echo ' <h5 style="font-weight: normal;">'.$blocked.'</h5>';
    if($row['blocked']==="blocked"){
        echo ' <a href="/ebay/admin.php?sellerid2='.$id.'" class="text-danger" ><u>unblock seller</u></a>';
    }else{
        echo ' <a href="/ebay/admin.php?sellerid='.$id.'" class="text-danger" ><u>block seller</u></a>';
    }
    echo ' </div>';
    echo ' </div>';
    echo '<hr>';
    
}

    ?>
</section>


<!-- products -->
<section id="products" >
    <h4 class="" style="margin-left:10px;" >products</h4>
    <form action="" method="post"  class="search-form" style="display: flex;" >
        <input type="text" class="form-control" style="border-color: black;margin-left:5px;" name="searchitem"    placeholder="search for items"  >
        <button type="submit" class="btn btn-primary" style="margin-left: 10px;margin-right:10px; color:white;font-family: Roboto Mono;" >search</button>
    </form>
    <br>
    <?php
    $sqlitem = "select * from auctions where name like '%$searchitem%' or itemdesc like '%$searchitem%' ";
    $resultitem = $conn->query($sqlitem);
    while($rowitem = $resultitem->fetch_assoc()){
        $id = $rowitem['id'];
        $itemname = $rowitem['name'];
        $itemdesc = $rowitem['itemdesc'];
        $itemseller = $rowitem['email'];
        $image1 = 'images/'.$rowitem['image1'];

        echo '<div class="theitem" >';
        echo '<img src="'.$image1.'" width="150px" height="150px" alt="profile picture" srcset="">';
        echo '<div  class="info" style="margin-left: 10px;">';
        echo '<h4 style="font-weight: normal;" >'.$itemname.'</h4>';
        echo  '<h5 style="font-weight: normal;">'.$itemseller.'</h5>';
        echo '<h5 style="font-weight: normal;">'.$itemdesc.'</h5>' ;  
        echo '<div style="display:flex;flex-direction: column;">' ;
        echo '<a href="/ebay/product.php?product_id='.$id.'" class="text-danger" ><u>view item</u></a> ';    
        echo '<a href="/ebay/admin.php?delid='.$id.'" class="text-danger" ><u>delete item</u></a>';   
        echo '</div>';
        echo '</div>';
        echo '</div>';
        echo '<hr>';
   
    }
    ?>
</section>

<!-- back to top button -->
<button class="btn btn-primary" style="position:fixed;bottom:20px;right:20px;" onclick="scrollToTop()" >back to top</button>
<script>
    function scrollToTop() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    }
</script>

</body>
</html>