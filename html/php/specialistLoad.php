<?php
//specialistLoad.php
//Tom Snelling

//this file receives a specified username and loads all tickets where that user is assigned as the specialist
//it outputs the results in an array
//this file is called from specialist-issues.js
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

	$table_tickets = "Tickets";

	//set specified username as appropriate variable
	$specialistName = $_GET['username'];

	//SQL to select all tickets where specified user is assigned as specialist and ticket isnt solved
	$sql = "SELECT * FROM $table_tickets WHERE specialist = '$specialistName' AND (status = 'pending' OR status = 'ongoing')";

    $allData = Array();

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

            //store some of results in array
            array_push($allData, array("type" => $type, "summary" => $summary, "id" => $id, "status" => $status, "timestamp" => $timestamp));
        }
    }
	//echo results
	echo json_encode($allData);

    mysqli_close($conn);

?>