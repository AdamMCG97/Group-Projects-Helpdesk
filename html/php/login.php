<?php
//login.php
//Tom Snelling

//this file receives a specified username and password when it is called
//it selects all data associated with the specified username and password
//it outputs some of this data in an array
//some elements of the array will be empty if the login was incorrect
//this file is called from login.js
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

	$table_users = "Users";
	//set specified values as variables
	$username = $_GET['username'];
	$password = $_GET['password'];

	//SQL query to select all information on user whose login matches specified values
	$sql = "SELECT * FROM $table_users WHERE username='$username' AND password='$password'";

	//execute sql
    if($res = $conn->query($sql)) {
            while ($row = $res->fetch_row()) {
                //store some results as variables
                $user = $row[1];
                $type = $row[3];
            }
    }

    mysqli_close($conn);
	//output stored results as array
	echo json_encode(array("user"=>$user, "type"=>$type));

?>