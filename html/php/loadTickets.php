<?php
//loadTickets.php
//Tom Snelling | Adam Morley

//this file acceses the database and selects all data for every ticket
//it then outputs some of this data in an array for every ticket
//this file is called from all-issues.js
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

	$table_tickets = "Tickets";

	//SQL to select all tickets data
	$sql = "SELECT * FROM $table_tickets";

	$allData = Array();

    //execute query
    if($res = $conn->query($sql)) {
        while ($row = $res->fetchRow()) {
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

            //store some variables in an array as an element of another array
            array_push($allData, array("type" => $type, "summary" => $summary, "id" => $id, "status" => $status, "timestamp" => $timestamp, "isArchived" => $isArchived));
        }
    }
	//echo results
	echo json_encode($allData);

    mysqli_close($conn);

?>