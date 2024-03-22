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

$sql = "select * from sellers where email='$email'";
$result =  $conn->query($sql);
$row = $result->fetch_assoc();
$name = $row['username'];
$bio = $row['bio'];
$dp = $row['dp'];


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
            <h4><?php echo $name ?></h4>
            <span><?php echo $bio ?></span><br>
           <a href=""  data-toggle="modal" data-target="#editprofilemodal" id="editprofile" style="text-decoration: none;" ><u class="text-danger" >edit</u></a>
        </div>
    </div>
</section>

        <!-- edit profile modal -->
        <div class="modal fade" id="editprofilemodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Edit profile</h5>
              </div>
              <div class="modal-body d-flex flex-column justify-content-center align-items-center">
                <div class="hey d-flex flex-column justify-content-center align-items-center">
                  <form action="/ebay/edit.php" method="post" enctype="multipart/form-data" >
                    <input type="text" placeholder="username" name="username" class="form-control">
                     <textarea   style="margin-top: 5px;" name="bio" placeholder="bio" class="form-control" cols="30" rows="2"></textarea>
                     <p>profile picture:</p>
                    <input type="file" name="file" accept="image/*" placeholder="dp" >
                    <input type="submit" class="btn " style="background-color: #FFAA33;color:white; " value="submit" >
                  </form>  
                 </div>
            </div>
            </div>
          </div>
        </div>
    
<a href="add.html" style="color:black;text-decoration:none;"><button class="btn btn-warning" style="margin-left: 10px; margin-top:10px;" >add an auction</button></a>
<!-- closed auction -->
<section style="margin-left: 10px;margin: top 10px;" >
    <h4>Closed auctions</h4>
    <?php
      $sqlclosed = "SELECT * FROM auctions WHERE email ='$email' AND status='off'";
      $resultclosed = $conn->query($sqlclosed);
      while ($row = $resultclosed->fetch_assoc()) {
        $id = $row['id'];
        $itemName = $row['name'];
        $minBid = $row['bid'];
        $currentBid ="winning bid: ". $row['currentbid'];
        $buyer ="buyer: ". $row['bidder'];
        $buyermail = $row['bidder'];
        $imageSrc = "images/" . $row['image1']; 

        echo '<div class="theitem">';
        echo '<img src="' . $imageSrc . '" width="130px" height="130px" alt="" srcset="">';
        echo '<div style="margin-left: 20px;align-self:center;">';
        echo '<h5>' . $itemName . '</h5>';
        echo '<h6 style="font-weight: normal;">'.$buyer.'</h6>';
        echo '<h6 style="font-weight: normal;">'.$currentBid.'</h6>';
        echo '<a href="/ebay/useraddress.php?email=' . $buyermail . '&id=' . $id . '" class=""  style="text-decoration: none;"><h6 class="text-danger" style="font-weight: normal;"><u>ship product</u></h6></a>';

        echo '</div>';
        echo '</div>';
    
      }
    ?>
</section>

<!-- pending auction -->
<section style="margin-left: 10px;margin: top 10px;" >
    <h4>pending auctions</h4>
    <!-- get pending auctions -->
    <?php
            $sql2 = "SELECT * FROM auctions WHERE email ='$email' AND status='on'";
            $result2 = $conn->query($sql2);

            // Generate HTML for each item
            while ($row = $result2->fetch_assoc()) {
                $id = $row['id'];
                $itemName = $row['name'];
                $minBid = $row['bid'];
                $currentBid = $row['currentbid'];
                $imageSrc = "images/" . $row['image1']; 

                // Generate HTML for each item
                echo '<div class="theitem">';
                echo '<img src="' . $imageSrc . '" width="130px" height="130px" alt="" srcset="">';
                echo '<div style="margin-left: 20px;align-self:center;">';
                echo '<h5>' . $itemName . '</h5>';
                echo '<h6 style="font-weight: normal;">Min bid: Ksh ' . $minBid . '</h6>';
                echo '<h6 class="text-dark" style="font-weight: normal;">Current bid: Ksh ' . $currentBid . '</h6>';
                echo '<a href="/ebay/product.php?product_id='.$id.'" style="text-decoration: none;"><h6 class="text-danger" style="font-weight: normal;"><u>View product</u></h6></a>';
                echo '<a href="#" class="delete-link" data-id="'.$id.'" style="text-decoration: none;"><h6 class="text-danger" style="font-weight: normal;"><u>Delete product</u></h6></a>';
                echo '</div>';
                echo '</div>';
            }

            // Close connection
            $conn->close();
            ?>

<script>
// Add event listener to delete links
document.addEventListener('DOMContentLoaded', function() {
    const deleteLinks = document.querySelectorAll('.delete-link');
    deleteLinks.forEach(function(link) {
        link.addEventListener('click', function(event) {
            event.preventDefault();
            const productId = link.getAttribute('data-id');
            // Call the PHP script to delete the item
            fetch('/ebay/deleteitem.php?id=' + productId, {
                method: 'DELETE',
            })
            .then(response => response.json())
            .then(data => {
                // Handle response from the server
                if (data.success) {
                    // Reload the page or remove the deleted item from the DOM
                    // For example, you can use link.closest('.theitem').remove();
                    location.reload(); // Reload the page
                } else {
                    console.error('Error deleting product:', data.message);
                }
            })
            .catch(error => {
                console.error('Error deleting product:', error);
            });
        });
    });
});
</script>

    
</section>

</body>
</html>