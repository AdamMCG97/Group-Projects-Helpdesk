<?php
//createProblemType.php
//Tom Snelling

//this file accesses the database and creates new problem types from user input
//this file is called from problem-types.js
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

	$table_problem_types = "Problemtypes";
	
	//get data entered by user and set to appropriate variables
	$desc = $_GET['description'];
	$subtype_of = $_GET['subtypeof'];
	
	//SQL to enter data into correct fields
	$sql = "INSERT INTO $table_problem_types (problem_type, subtype_of) VALUES ('$desc', '$subtype_of')";

    //execute SQL
    if(!$conn->query($sql)) {
        echo "Failed to save data: (" . $conn->connect_errno . ") " . $conn->connect_error;
    }
    else {
        echo "OK";
    }

    mysqli_close($conn);

?>