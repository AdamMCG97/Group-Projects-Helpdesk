<?php
//deleteTicket.php
//Tom Snelling | Ghassan Ebrahim

//this file acceses the database and deletes the selected ticket
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


    $table = "Tickets";

	//get ticket id
	$id = $_GET['id'];
	
	//SQL to delete selected ticket
	$sql = "DELETE FROM $table WHERE id=$id";

	//execute SQL
    if(!$conn->query($sql)) {
        echo "Failed to delete data: (" . $conn->connect_errno . ") " . $conn->connect_error;
    }

    mysqli_close($conn);

?>