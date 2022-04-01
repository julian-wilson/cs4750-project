<?php
require('connect-db.php');
require('restaurant-db.php');

// get username of who's logged in
session_start();
$username = $_SESSION["username"];

// get current restaurant id
if(isset($_GET["rid"])){
  $restaurant_id = $_GET["rid"];
} 

// get all reviews
$list_of_reviews = getAllReviews($restaurant_id);

// handle add review button
if($_SERVER['REQUEST_METHOD'] == "POST"){
    if(!empty($_POST['buttonAction'] && $_POST['buttonAction'] == "Add review")){
        $datetime = date("Y-m-d h:i:s", time());
        addReview($username, $_POST["review"], $datetime, $restaurant_id);   
        $list_of_reviews = getAllReviews($restaurant_id);
        
      }
}

?>


<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">  
  
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  <meta name="author" content="allison">
  <meta name="description" content="specific restaurant info page for project">  
    
  <title>Restaurant Page</title>
  
  <!-- if you choose to use CDN for CSS bootstrap -->  
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  
  <!-- you may also use W3's formats...formatting for display table -->
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  
  <!-- If you choose to use a favicon, specify the destination of the resource in href -->
  <link rel="icon" type="image/png" href="http://www.cs.virginia.edu/~up3f/cs4750/images/db-icon.png" />
  
  <!-- include your CSS -->
  <!-- <link rel="stylesheet" href="custom.css" />  -->
       
</head>


<body>
<div class="container">
  <h1><?php echo getARestaurant($restaurant_id)[0]["name"]; ?></h1>  <!--id is undefined, but to getARestaurant(), the param is id...this seems like the right track-->
  
  <h3>Address: <?php echo getARestaurant($restaurant_id)[0]["address"]; ?></h3> 
  <h3>Rating: <?php echo getARestaurant($restaurant_id)[0]["starRating"]; ?>/5</h3> 
  <h3>Price: <?php printMoneySign(getARestaurant($restaurant_id)[0]["price"]); ?></h3> 
  <h3>Cuisine: <?php echo getARestaurant($restaurant_id)[0]["cuisine"]; ?></h3>

<!-- display past reviews -->
<h1>List of Reviews</h1>
  <table class="w3-table w3-bordered w3-card-4" style="width:100%">
  <thead>
    <tr style="background-color:#B0B0B0">
      <th width="100%">Reviews</th>
    </tr>
  </thead>
  <?php foreach ($list_of_reviews as $r): ?>
  <tr>
    <td><?php echo $r["text"]; ?></td>
  </tr>
  <?php endforeach; ?>
  </table>



  <!-- form for review -->
  <h1>Create a Review</h1>
  <form name="mainForm" action="restaurantpage.php?rid=<?php echo $restaurant_id ?>" method="post">  

  <div class="row mb-3 mx-3">
    Type Your Review:
    <input type="text" class="form-control" name="review" required />        
  </div>  

  <input type="submit" value="Add review" name="buttonAction" class="btn btn-dark" title="add a review" />
  <input type="hidden" name = "restaurantid" value = $restaurant>
</form>    



  <!-- CDN for JS bootstrap -->
  <!-- you may also use JS bootstrap to make the page dynamic -->
  <!-- better to put javascript towards bottom of page-->
  <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script> -->
  
  <!-- for local -->
  <!-- <script src="your-js-file.js"></script> -->  
  
</div>    
</body>
</html>