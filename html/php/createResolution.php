<?php
//createResolution.php
//Tom Snelling | Timo Kiukkanen

//this file accesses the database and creates a resolution for a ticket
//it populates the fields with data entered by the user and updates the ticket status
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

	$table_retickets = "Resolvedtickets";

	//get data enetered by user and set to appropriate variables
	//get ticket id
	$id = $_GET['id'];
	$solvedby = $_GET['operator'];
	$resolution_detail = $_GET['resolutionDetail'];
	
	//SQL to enter data into correct fields for correct ticket
	$sql = "INSERT INTO $table_retickets (id, solvedby, details) VALUES ('$id', '$solvedby', '$resolution_detail')";
	
	//execute SQL
    if(!$conn->query($sql)) {
        echo "Failed to save data: (" . $conn->connect_errno . ") " . $conn->connect_error;
    }

	$table_tickets = "Tickets";
	
	//SQL to update ticket status to correct value now solved
	$sql = "UPDATE $table_tickets SET status='solved' WHERE id='$id'";
	
	//execute SQL
    if(!$conn->query($sql)) {
        echo "Failed to save data: (" . $conn->connect_errno . ") " . $conn->connect_error;
    }
    else {
        echo "OK";
    }

    mysqli_close($conn);

?>