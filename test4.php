<html>
<!DOCTYPE html>

<html class="full" lang="en">

	<head>
    	<meta charset="utf-8">
    	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    	<meta name="description" content="">

	    <title>Movie Trip: Travel Like a Movie Star</title>

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

        <div id="menu">
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
	if(isset($_GET['id'])) {
		$id = $_GET['id'];
		//print("$id<br>\n");
	}

// connecting to a database

		require_once('cfg.php');
		$dbh = new PDO($db['dsn'], $db['user'], $db['password']);
		//print('Success<br>');

		$sql_movie_title = "SELECT Title FROM Movie WHERE Movie_Id = '" . $id . "'";
		$st2 = $dbh->query($sql_movie_title);

		while($result2 = $st2->fetch(PDO::FETCH_ASSOC)){
        	//print($result['Location_Id'].' '.$result['Latitude'].' '.$result['Longitude'].' '.$result['Description'].'</BR>');
			echo '<div class="container"><h3>Filming Locations of "',$result2['Title'], '":</h3>';
		}

	try{
		// require_once('cfg.php');
		// $dbh = new PDO($db['dsn'], $db['user'], $db['password']);
		// //print('Success<br>');

		$sql_movie_location = "SELECT Distinct Location.* FROM Movie, Filmed_In, Location WHERE Movie.Movie_Id = '" . $id . "' AND Location.Location_Id = Filmed_In.Location_Id AND Movie.Movie_Id = Filmed_In.Movie_Id";
		$st = $dbh->query($sql_movie_location);



		while($result = $st->fetch(PDO::FETCH_ASSOC)){
        	//print($result['Location_Id'].' '.$result['Latitude'].' '.$result['Longitude'].' '.$result['Description'].'</BR>');
			echo '<a href="https://maps.google.com/maps?q=', $result['Latitude'], ',', $result['Longitude'], '"> - ', $result['Description'], '</a><br>';
		}

	echo '</div>';

	}catch (PDOException $e){
    	print('Error:'.$e->getMessage());
    	die();
	}

$dbh = null;

?>

	</body>
</html>