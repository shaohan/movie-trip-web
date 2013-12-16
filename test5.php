<html>
	<head>
		<title>PHP TEST</title>
	</head>
<body>

<?php
	$city_name = $_GET['location'];

// connecting to a database

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

			print($result1['Name'] . ', ' . $result2['Name'] . ', ' . $result3['Name'] . ' <a href="test6.php?city_id=' . $city_id . '">I am in here.</a></br>');
		}

	}catch (PDOException $e){
		print('Error:'.$e->getMessage());
		die();
	}
	

	$dbh = null;
?>

	</body>
</html>
