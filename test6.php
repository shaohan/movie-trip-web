<html>
	<head>
		<title>Movie Trip</title>
	</head>
	<body>

<?php
	if(isset($_GET['city_id'])) {
		$city_id = $_GET['city_id'];
	}

// connecting to a database

try{
	require_once('cfg.php');
	$dbh = new PDO($db['dsn'], $db['user'], $db['password']);
	//print('Success<br>');

	$sql_city_location = "SELECT * FROM Location WHERE City_Id = '$city_id'";
	$st4 = $dbh->query($sql_city_location);

	while($result4 = $st4->fetch(PDO::FETCH_BOTH)){

        	$location_id = $result4['Location_Id'];
		$sql_location_movie = "SELECT Distinct * FROM Filmed_In WHERE Location_Id = '$location_id'";
		$st5 = $dbh->query($sql_location_movie);
		$result5 = $st5->fetch(PDO::FETCH_BOTH);

		$movie_id = $result5['Movie_Id'];
		print($movie_id);

		$sql_movie = "SELECT * FROM Movie WHERE Movie_Id = '$movie_id'";
		$st6 = $dbh->query($sql_movie);
		$result6 = $st6->fetch(PDO::FETCH_BOTH);
		print($result6['Title']);
		}

//print($result['Location_Id'].' '.$result['Latitude'].' '.$result['Longitude'].' '.$result['Description'].'</BR>');
//		print('<a href="https://maps.google.com/maps?q='.$result['Latitude'].','.$result['Longitude'].'">* '.$result['Description'].'</a></BR>');
	}

}catch (PDOException $e){
    print('Error:'.$e->getMessage());
    die();
}

$dbh = null;

?>

	</body>
</html>