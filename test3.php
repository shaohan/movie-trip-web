<html>
	<head>
		<title>PHP TEST</title>
	</head>
	<body>

<?php
	if(isset($_GET['id'])) {
		$id = htmlspecialchars($_GET['id']);
		//print("$id<br>\n");
	}

	$url2 = "http://www.omdbapi.com/?i=$id";
	$SearchResult2 = file_get_contents($url2, true);

	if ($SearchResult2 == false) {
       echo "error";
       return;
	} 
	
	$dec_obj=json_decode($SearchResult2);
	$dec_arr=json_decode($SearchResult2, true);

	$premovieid = $dec_arr['Title'] . $dec_arr['Year'] . $dec_arr['imdbID'] ;
	$movie_id = md5($premovieid);

// connecting to a database

try{
	require_once('cfg.php');
	$dbh = new PDO($db['dsn'], $db['user'], $db['password']);
	//print('Success<br>');

	$stmt = $dbh->prepare("insert into Movie (Movie_Id,Title,Year,IMDb_Id,Genre,Description,Poster) values (:Movie_Id,:Title,:Year,:IMDb_Id,:Genre,:Description,:Poster)"); //counter SQL injection
	$stmt->execute(array(":Movie_Id"=>$movie_id,":Title"=>$dec_arr['Title'],":Year"=>$dec_arr['Year'],":IMDb_Id"=>$dec_arr['imdbID'],":Genre"=>$dec_arr['Genre'],":Description"=>$dec_arr['Plot'],":Poster"=>$dec_arr['Poster']));
	//echo "done </BR>";

	$sql_movie_data = "SELECT * FROM Movie WHERE Movie_Id = '" . $movie_id . "'";
	$st = $dbh->query($sql_movie_data);

	$result = $st->fetch(PDO::FETCH_BOTH);
	echo "Movie_Data </BR>";
	print("Movie_Id(MD5): " . $result['Movie_Id'] . "</BR>");
	print("IMDb_Id: " . $result['IMDb_Id'] . "</BR>");
	print("Title: " . $result['Title'] . "</BR>");
	print("Year: " . $result['Year'] . "</BR>");
	print("Genre: " . $result['Genre'] . "</BR>");
	print("Description: " . $result['Description'] . "</BR>");
	print("<img src=\"" .  $result['Poster'] . "\"/>");
	echo '<p>Would you like to look the filming location data? <a href="test4.php?id=', $movie_id, '">Yes</a>';

}catch (PDOException $e){
    print('Error:'.$e->getMessage());
    die();
}

$dbh = null;

?>

	</body>
</html>