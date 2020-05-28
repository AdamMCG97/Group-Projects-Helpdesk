<?php
//setAvailability.php
//Tom Snelling

//this file receives a username when it is called
//it updates that users availability based on the value specified
//this file is called from specialist-issues.js
	//error checking
	ini_set('display_errors', 1);	
	ini_set('display_startup_errors', 1);
    error_reporting(0);

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

	$table_users = "Users";
	
	//set specified values to appropriate variables
	$specialist = $_GET['specialist'];
	$availability = $_GET['availability'];

	//SQL to update users availability based on variable
	$sql = "UPDATE $table_users SET available=$availability WHERE username='$specialist'";

	//execute sql
    if(!$conn->query($sql)) {
        echo "Failed to save data: (" . $conn->connect_errno . ") " . $conn->connect_error;
    }
    else {
        echo "OK";
    }

    mysqli_close($conn);

?>