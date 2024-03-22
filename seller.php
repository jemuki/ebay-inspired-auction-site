<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ebay</title>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<link href='https://fonts.googleapis.com/css?family=Pacifico' rel='stylesheet'>
<link href='https://fonts.googleapis.com/css?family=Roboto Mono' rel='stylesheet'>


<link rel="icon" href="images/elogo.png" type="image/x-icon">
  <link rel="shortcut icon" href="images/elogo.png" type="image/x-icon">

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
    <br>
    <section>
    <section class="row" >
        <div class="col-md-2" >
        <a href="home.html"> <img src="images/elogo.png" width="150px" height="50px" style="border-radius: 10px; margin-left:5px;margin-top:5px; margin-bottom:10px;" alt="" srcset=""></a>       
        </div>
        <div class="col-md-6"  style="align-self: center;">
                <form action="" class="search-form" style="display: flex;" >
                    <input type="text" class="form-control" style="border-color: black;margin-left:5px;"  placeholder="search for anything" required >
                    <button type="submit" class="btn btn-warning" style="margin-left: 10px;margin-right:10px; color:white;font-family: Roboto Mono;" >search</button>
                </form>
        </div>
       </section>
</section>

   <!-- user details -->
<section>
    <div class="username" >
        <img src="images/chef.jpeg" width="100px" height="100px" style="border-radius: 50%;" alt="">
        <div style="margin-left: 20px;align-self:center;" >
            <h4>Akamai electronics</h4>
            <span>Happy to do business with you!</span><br>
            <span>joined 2022</span>
        </div>
    </div>
</section>

<!-- listed items -->
<h5 style="margin-left: 5px;" >Listed items</h5>
<!-- item 1 -->
<div class="theitem" >
<img src="https://i.ebayimg.com/thumbs/images/g/5H8AAOSwOnll1TOd/s-l500.webp" width="130px" height="130px"  alt="" srcset="">
<div style="margin-left: 20px;align-self:center;" >
<h5>DELL se2160 TV</h5>
<h6 style="font-weight: normal;" >min bid: Ksh 13000</h6>
<h6 class="text-dark" style="font-weight: normal;" >current bid: Ksh 6000</h6>
<a href="" style="text-decoration: none;">   <h6 class="text-danger"  style="font-weight: normal;" ><u>view product</u></h6></a>
</div>
</div>
<!-- item 2 -->
<div class="theitem" >
    <img src="https://i.ebayimg.com/thumbs/images/g/hOQAAOSwNVBlcOPh/s-l500.webp" width="130px" height="130px"  alt="" srcset="">
    <div style="margin-left: 20px;align-self:center;" >
    <h5>Samsung CF390 27"</h5>
    <h6 style="font-weight: normal;" >min bid: Ksh 13000</h6>
    <h6 class="text-dark" style="font-weight: normal;" >current bid: Ksh 6000</h6>
    <a href="" style="text-decoration: none;">   <h6 class="text-danger"  style="font-weight: normal;" ><u>view product</u></h6></a>
    </div>
</div>
    <!--  item 3-->
    <div class="theitem" >
      <img src="https://i.ebayimg.com/thumbs/images/g/R-EAAOSwN~JluVKq/s-l500.webp" width="130px" height="130px"  alt="" srcset="">
        <div style="margin-left: 20px;align-self:center;" >
      <h5>Self balancing scooter</h5>
      <h6 style="font-weight: normal;" >min bid: Ksh 13000</h6>
      <h6 class="text-dark" style="font-weight: normal;" >current bid: Ksh 36000</h6>
      <a href="" style="text-decoration: none;">   <h6 class="text-danger"  style="font-weight: normal;" ><u>view product</u></h6></a>
      </div>
      </div>
  
        
</body>
</html>