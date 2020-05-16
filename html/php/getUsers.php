<?php
//getUsers.php
//Tom Snelling | Joe Graham

//this file accesses the database and selects users of a type specified when the file is called
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

	$table = "Users";
	
	//set specified type to variable
	$type = $_GET['type']; // either Operator or Specialist

	//SQL to get data for users of specified type
	$sql = "SELECT * FROM $table WHERE type='$type'";

    $allData = Array();

	//execute query
    if($res = $conn->query($sql)) {
        while ($row = $res->fetch_row()) {
            //save user data in array
            $id = $row[0];
            $user = $row[1];
            $name = $row[4] . " " . $row[5];

            //add array for each user into output array
            array_push($allData, array("id" => $id, "user" => $user, "name" => $name));
        }
    }
	//echo results
	echo json_encode($allData);

    mysqli_close($conn);

?>