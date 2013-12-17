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

	$city_name = $_GET['location'];

// connecting to a database

	echo '<div class="container"><h3>Searching Result for "', $city_name, '":</h3><br>';

	try{
		require_once('cfg.php');
		$dbh = new PDO($db['dsn'], $db['user'], $db['password']);

		$sql_city = "SELECT * FROM City WHERE Name = '$city_name'";
		$st1 = $dbh->query($sql_city);

		while($result1 = $st1->fetch(PDO::FETCH_BOTH)){

			$country_id = $result1['Country_Id'];
			$city_id = $result1['City_Id'];

			$sql_country = "SELECT * FROM Country WHERE Country_Id = '$country_id'";
			$st2 = $dbh->query($sql_country);
			$result2 = $st2->fetch(PDO::FETCH_BOTH);

			$region_id = $result2['Region_Id'];
			$sql_region = "SELECT * FROM Region WHERE Region_Id = '$region_id'";
			$st3 = $dbh->query($sql_region);
			$result3 = $st3->fetch(PDO::FETCH_BOTH);

			echo '<div id="city-matches"><span class="city-name">', $result1['Name'], '</span>', ', ', $result2['Name'], ', ', $result3['Name'], ' -->', ' <a href="test6.php?city_id=', $city_id, '"> I am in here</a></br></div>';
		}

	}catch (PDOException $e){
		print('Error:'.$e->getMessage());
		die();
	}


	$dbh = null;
	echo '</div>';
?>

	</body>
</html>
