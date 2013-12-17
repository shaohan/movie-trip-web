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

	$input_data = $_GET['title'];
	$rawurlencoded = rawurlencode($input_data);
	$url = "http://www.imdb.com/xml/find?json=1&nr=1&tt=on&q=$rawurlencoded"; 	// Access IMDb API with title query
	$SearchResult = file_get_contents($url, true);

	if ($SearchResult == false) {
       echo "Sorry, no result.";
       return;
	}

	$dec_obj=json_decode($SearchResult);                  // return parse result as an object
	$dec_arr=json_decode($SearchResult, true);            // return parse result as an allay

	echo '<div class="container"><h3>Results:</h3>';

	$a = 0;
	while($a < count($dec_arr['title_popular']))
		{
			$desc = $dec_arr['title_popular'][$a]['description'];
			$desc = preg_replace("/,\s*<a[^>]*>([^<]*)<\/a>\.*/i", "", $desc);
			echo '<p><a href="test3.php?id=', $dec_arr['title_popular'][$a]['id'], '">', $dec_arr['title_popular'][$a]['title'], ' (', $desc, ')</a>';
        	$a++;
        }

	$b = 0;
	while($b < count($dec_arr['title_substring']))
		{
			$desc = $dec_arr['title_substring'][$b]['description'];
			$desc = preg_replace("/,\s*<a[^>]*>([^<]*)<\/a>\.*/i", "", $desc);
			echo '<p><a href="test3.php?id=', $dec_arr['title_substring'][$b]['id'], '">', $dec_arr['title_substring'][$b]['title'], ' (', $desc, ')</a>';
        	$b++;
        }

    echo '</div>';

?>
</body>
</html>