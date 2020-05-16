<?php
//topTags.php
//Adam Morley

//this file outputs an array of tags and the amount of times they exist in the database
//it outputs the top 5 results in descending order
//this file is called from view-analytics.js
	//error checking
	ini_set('display_errors', 1);	
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

	//database connection
	$url = parse_url(getenv("DATABASE_URL"));

	$server = $url["host"];
	$username = $url["user"];
	$password = $url["pass"];
	$db = substr($url["path"], 1);

	$conn = new mysqli($server, $username, $password, $db);

	if ($conn->connect_errno) {
		echo "Failed to connect to MySQL: (" . $conn->connect_errno . ") " . $conn->connect_error;
	}

	//SQL to select top 5 tags, how many times they appear in db and in order 
	$sql = "SELECT tag, COUNT( * ) FROM  Tags GROUP BY tag ORDER BY COUNT( * ) DESC LIMIT 0, 5";

	$allData = Array();

	//execute query
	if($res = $conn->query($sql)) {
		while ($row = $res->fetch_row()) {
			//store results in appropriate variables
			$tag = $row[0];
			$count = $row[1];
			//store variables in array for each tag
			array_push($allData, array("tag" => $tag, "count" => $count));
		}
	}
	//echo results
	echo json_encode($allData);

	mysqli_close($conn);

?>

