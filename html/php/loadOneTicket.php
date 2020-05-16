<?php
//loadOneTicket.php
//Tom Snelling

//this file receives a specified ticket id and outputs an array containing all information on that ticket
//this includes information about the ticket resolution if it exists
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

	//database tables
	$table_tickets = "Tickets";
	$table_retickets = "Resolvedtickets";

	//specified id as variable
	$getId = $_GET['id'];

	//SQL to get ticket information for ticket with specified id
	$sql = "SELECT * FROM $table_tickets WHERE id=$getId";
	
	//execute query
    if($res = $conn->query($sql)) {
        while ($row = $res->fetch_row()) {
            //store results in appropriate variables
            $first_name = $row[0];
            $last_name = $row[1];
            $specialist = $row[2];
            $type = $row[3];
            $summary = $row[4];
            $details = $row[5];
            $id = $row[6];
            $status = $row[7];
            $timestamp = $row[8];
            $operator = $row[9];
            $email = $row[10];
            $followup = $row[11];
            $isArchived = $row[12];
            $hwserial = $row[13];
            $osname = $row[14];
            $swname = $row[15];
            $swversion = $row[16];
            $swlicense = $row[17];
            $problem_type = $row[18];
        }
    }
	
	//SQL to get resolution information on ticket with specified id
	$sql = "SELECT * FROM $table_retickets WHERE id=$getId";

	//execute query
    if($res = $conn->query($sql)) {
        while ($row = $res->fetch_row()) {
            //store results in appropriate variables
            $resolved_by = $row[1];
            $resolution_details = $row[2];
            $resolved_at = $row[3];
        }
    }

	//add results to an array and output array
	echo json_encode(array("firstName"=>$first_name, "lastName"=>$last_name, "specialist"=>$specialist, "type"=>$type, "problemtype"=>$problem_type, "summary"=>$summary,
		"details"=>$details, "id"=>$id, "status"=>$status, "timestamp"=>$timestamp, "operator"=>$operator, "email"=>$email, "followup"=>$followup,
		"isArchived"=>$isArchived, "hwserial"=>$hwserial, "osname"=>$osname, "swname"=>$swname, "swversion"=>$swversion, "swlicense"=>$swlicense, "solvedBy"=>$resolved_by, "solution"=>$resolution_details, "solvedAt"=>$resolved_at));

    mysqli_close($conn);

?>