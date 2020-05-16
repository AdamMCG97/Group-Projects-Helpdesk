<?php
//getTags.php
//Tom Snelling

//this file loads all the tags associated with a ticket id sent to this file
//it outputs the results in an array
//this file is called from view-issue.js	
	//error checking
	ini_set('display_errors', 1);	
	ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    $url = parse_url(getenv("DATABASE_URL"));

    $server = $url["host"];
    $username = $url["user"];
    $password = $url["pass"];
    $db = substr($url["path"], 1);

    $conn = new mysqli($server, $username, $password, $db);

    if ($conn->connect_errno) {
        echo "Failed to connect to MySQL: (" . $conn->connect_errno . ") " . $conn->connect_error;
    }

	$table = "Tags";
	//set id sent to file as variable
	$getId = $_GET['id'];

	//SQL to select all tags with correct id
	$sql = "SELECT tag FROM $table WHERE id=$getId";

    $tags = Array();

	//execute query
    if($res = $conn->query($sql)) {
        while ($row = $res->fetch_row()) {
            //add each tag to an array
            array_push($tags, $row[0]);
        }
    }
	
	//echo array
	echo json_encode(array("tags"=>$tags));

    mysqli_close($conn);

?>