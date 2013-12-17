<!DOCTYPE html>

<html class="full" lang="en">

	<head>
    	<meta charset="utf-8">
    	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    	<meta name="description" content="">

    	<title>Movie Trip - Search Result</title>

	    <!-- CSS sheets -->
	    <link href="css/style.css" rel="stylesheet">
    	<link href="css/bootstrap.css" rel="stylesheet">
	 </head>

<body>

<nav class="navbar navbar-fixed navbar-inverse">
      <div class="container">
          <div id="branding-logo">
            <img src="image/icon.png" alt="logo">
          </div><!-- #branding-logo -->
        	<a class="navbar-brand" href="test1.html">Movie Trip</a>

        <div id="menu" style="display:none">
          <div class="collapse navbar-collapse navbar-ex1-collapse">
            <ul class="nav navbar-nav">
              <li><a href="#mytrips">My Trips</a></li>
              <li><a href="#checkin-history">History</a></li>
              <li><a href="#loginin" style=>Login</a></li>
            </ul>
          </div><!-- /.navbar-collapse -->
        </div><!-- /.menu -->
      </div><!-- /.container -->
    </nav>

<?php

	echo '<div class="container">';

	if(isset($_GET['city_id'])) {
		$city_id = $_GET['city_id'];
	}


// connecting to a database

try{
	require_once('cfg.php');
	$dbh = new PDO($db['dsn'], $db['user'], $db['password']);
	//print('Success<br>');


	$sql_city_name = "SELECT Name FROM City WHERE City_Id = '" . $city_id . "'";
	$st7 = $dbh->query($sql_city_name);

	while($result7 = $st7->fetch(PDO::FETCH_ASSOC)){
        //print($result['Location_Id'].' '.$result['Latitude'].' '.$result['Longitude'].' '.$result['Description'].'</BR>');
		echo '<h3>Movies filmed in "',$result7['Name'], '":</h3>';
	}


	$sql_city_location = "SELECT * FROM Location WHERE City_Id = '$city_id'";
	$st4 = $dbh->query($sql_city_location);


	while($result4 = $st4->fetch(PDO::FETCH_BOTH)){

        $location_id = $result4['Location_Id'];
		$sql_location_movie = "SELECT Distinct * FROM Filmed_In WHERE Location_Id = '$location_id'";
		$st5 = $dbh->query($sql_location_movie);
		$result5 = $st5->fetch(PDO::FETCH_BOTH);

		$sql_movie = "SELECT * FROM Movie WHERE Movie_Id = '$movie_id'";
		$st6 = $dbh->query($sql_movie);
		$result6 = $st6->fetch(PDO::FETCH_BOTH);
		$movie_id = $result5['Movie_Id'];
		echo '<a href="test4.php?id=', $movie_id, '">', $result6['Title'],'</a><br>';
		}



} catch (PDOException $e){
    print('Error:'.$e->getMessage());
    die();
}

$dbh = null;


echo '</div>';


?>

	</body>
</html>