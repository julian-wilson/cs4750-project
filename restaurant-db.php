<?php
require('connect-db.php');

function getAllRestaurants()
{
	global $db;
	$query = "select * from restaurant";
	// $statement = $db->query($query);
	
	$statement = $db->prepare($query);
	$statement->execute();
	
	$results = $statement->fetchAll();
	$statement->closeCursor();
	return $results;
}

function printMoneySign($num)
{
	for ($x = 0; $x < $num; $x++) {
  		echo "$";
	}
}

function getAllReviews($restaurant_id) {
    //db handler
    global $db;

    //sql
    $query = "select text from words JOIN review ON words.ID = review.review_ID where restaurant_id = :id"; //where restaurant_id = 

    //execute sql
    $statement = $db->prepare($query);
	$statement->bindValue(':id', $restaurant_id);
    $statement->execute();

    //fetchAll() returns an array of all rows in the result set
    $results = $statement->fetchAll();

    //release: pdo can be used again
    $statement->closeCursor();

    return $results;
}

function getARestaurant($id) {

	global $db;
	$query = "select * from restaurant where id = :id;";
	
	$statement = $db->prepare($query);
	$statement->bindValue(':id', $id);
	$statement->execute();
	
	$results = $statement->fetchAll();
	$statement->closeCursor();
	return $results;

}

function addReview($username, $text, $datetime, $restaurantID) {

	global $db;
	$query = "insert into textContents values(:text, :length);";
	
	$statement = $db->prepare($query);
	$statement->bindValue(':text', $text);
	$statement->bindValue(':length', strlen($text));
	$statement->execute();

	// insert into words(username, text, date_time) output inserted.id into @InsertedID values("jww2rfe", "testing", "2022-03-31 00:00:00");
	$query = "insert into words(username, text, date_time) values(:un, :text, :datetime)";
	$statement = $db->prepare($query);
	$statement->bindValue(':un', $username);
	$statement->bindValue(':text', $text);
	$statement->bindValue(':datetime', $datetime);
	$statement->execute();

	$id = $db->lastInsertID();

	$results = $statement->fetchAll();
	$statement->closeCursor();

	$query = "insert into review values (:reviewID, :restaurantID);";
	
	$statement = $db->prepare($query);
	$statement->bindValue(':reviewID', $id);
	$statement->bindValue(':restaurantID', $restaurantID);
	$statement->execute();

}

?>