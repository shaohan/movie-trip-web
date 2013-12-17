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
	echo '<div class="container"><h3>', $result['Title'],'&nbsp(', $result['Year'], ')&nbsp', '</h3>';
	echo 'Title: ', $result['Title'], '<br>';
	echo 'Movie_Id(MD5): ', $result['Movie_Id'] , '<br>';
	echo 'IMDb_Id: ', $result['IMDb_Id'], '<br>';
	echo 'Year: ', $result['Year'], '<br>';
	echo 'Genre: ', $result['Genre'], '<br>';
	echo 'Description: ', $result['Description'], '<br><br>';

	print("<img src=\"" .  $result['Poster'] . "\"/>");

	echo '<br><br>';
	echo '<h3>Would you like to look the filming location data? <a href="test4.php?id=', $movie_id, '">Yes</a></h3>';
	echo '</div>';


} catch (PDOException $e){
    print('Error:'.$e->getMessage());
    die();
}

$dbh = null;

?>

</body>
</html>