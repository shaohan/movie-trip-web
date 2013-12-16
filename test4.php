<html>
	<head>
		<title>PHP TEST</title>
	</head>
	<body>

<?php
	if(isset($_GET['id'])) {
		$id = $_GET['id'];
		//print("$id<br>\n");
	}

// connecting to a database

try{
	require_once('cfg.php');
	$dbh = new PDO($db['dsn'], $db['user'], $db['password']);
	//print('Success<br>');

	$sql_movie_location = "SELECT Distinct Location.* FROM Movie, Filmed_In, Location WHERE Movie.Movie_Id = '" . $id . "' AND Location.Location_Id = Filmed_In.Location_Id AND Movie.Movie_Id = Filmed_In.Movie_Id";
	$st = $dbh->query($sql_movie_location);

	while($result = $st->fetch(PDO::FETCH_ASSOC)){
        //print($result['Location_Id'].' '.$result['Latitude'].' '.$result['Longitude'].' '.$result['Description'].'</BR>');
		print('<a href="https://maps.google.com/maps?q='.$result['Latitude'].','.$result['Longitude'].'">* '.$result['Description'].'</a></BR>');
	}

}catch (PDOException $e){
    print('Error:'.$e->getMessage());
    die();
}

$dbh = null;

?>

	</body>
</html>