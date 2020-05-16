<?php
//getUserType.php
//Tom Snelling

//this file accesses the database a username and type that match the username sent when the file was called
//it outputs the results in an array
//this file is called from common.js
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

	$table_users = "Users";

	//set specified username as variable
	$username = $_GET['username'];

	//SQL to select all data associated with username in table
	$sql = "SELECT * FROM $table_users WHERE username='$username'";
	
	//run query
    if($res = $conn->query($sql)) {

        while ($row = $res->fetch_row()) {
            //save data as variables
            $user = $row[1];
            $type = $row[3];
        }

        //add variables to array and output array
        echo json_encode(array("user" => $user, "type" => $type));
    }

    mysqli_close($conn);

?>