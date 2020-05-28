<?php
//update.php
//Tom Snelling | Adam Morley

//this file receives information for a ticket and updates the correct values for a specified ticket
//this file is called from view-issue.js
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

	$table_tickets = "Tickets";

	//store received values in appropriate variables
	$id = $_GET['id'];
	$status = $_GET['status'];
	$first_name = $_GET['firstname'];
	$last_name = $_GET['lastname'];
	$email = $_GET['email'];
	$specialist = $_GET['specialist'];
	$type = $_GET['type'];
	$problem_type = $_GET['problemtype'];
	$summary = $_GET['summary'];
	$details = $_GET['details'];
	$hwserial = $_GET['hwserial'];
	$osname = $_GET['osname'];
	$swname = $_GET['swname'];
	$swversion = $_GET['swversion'];
	$swlicense = $_GET['swlicense'];
	$archived = $_GET['archived'];

	//SQL to update values for each field of the ticket with the appropriate variable
	$sql = "UPDATE $table_tickets SET status='$status', callerfirstname='$first_name', callerlastname='$last_name', specialist='$specialist', type='$type', summary='$summary', details='$details', email='$email', hwserial='$hwserial', osname='$osname', swname='$swname', swversion='$swversion', swlicense='$swlicense', problemtype='$problem_type', archived = '$archived' WHERE id='$id'";

	//execute sql
    if(!$conn->query($sql)) {
        echo "Failed to save data: (" . $conn->connect_errno . ") " . $conn->connect_error;
    }
    else {
        echo "OK";
    }

    mysqli_close($conn);

?>