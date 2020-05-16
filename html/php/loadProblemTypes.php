<?php
//loadProblemTypes.php
//Tom Snelling

//this file loads all problem types
//it stores the results in an array and outputs the array
//this file is called from create-issue.js
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

	$tabel_problem_types = "Problemtypes";
	
	//SQL to select all information in table
	$sql = "SELECT * FROM $tabel_problem_types";

	$allData = Array();

    //execute query
    if($res = $conn->query($sql)) {
        while ($row = $res->fetch_row()) {
            //store results in appropriate variables
            $id = $row[0];
            $desc = $row[1];
            $subtype_of = $row[2];
            //each row is stored in an array which is then stored in another array
            array_push($allData, array("id" => $id, "description" => $desc, "subtype_of" => $subtype_of));
        }
    }
	//output array
	echo json_encode($allData);

    mysqli_close($conn);

?>