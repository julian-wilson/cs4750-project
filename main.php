<?php
require("connect-db.php");
require("restaurant-db.php");

$list_of_restaurants = getAllRestaurants();
// $friend_to_update = null;
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet"
     href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
  <title>Charlottesville Restaurants</title>  
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">  
</head> 
<body>

<div class="container">
  <h1>List of Restaurants</h1>
  <table class="w3-table w3-bordered w3-card-4" style="width:90%">
    <thead>
    <tr style="background-color:#B0B0B0">
      <th width="25%">Name</th>
      <th width="25%">Address</th>
      <th width="25%">Rating</th>
	<th width="25%">Price</th>
      <th width="25%">Cuisine</th>
    </tr>
    </thead>
    <?php foreach ((array) $list_of_restaurants as $restaurant): ?>
    <tr>
      <td><a href="restaurantpage.php?rid=<?php echo $restaurant['id']; ?>"><?php echo $restaurant['name']; ?></a></td>     
      <td><?php echo $restaurant['address']; ?></td>
      <td><?php echo $restaurant['starRating']; ?></td>
	    <td><?php printMoneySign($restaurant['price']); ?></td>
	    <td><?php echo $restaurant['cuisine']; ?></td>
    </tr>
    <?php endforeach; ?>
  </table>
</div> 

</body>
</html>