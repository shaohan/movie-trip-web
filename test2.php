<html>
	<head>
		<title>PHP TEST</title>
	</head>
<body>

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

	echo "<p>Results:";
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

?>
</body>
</html>