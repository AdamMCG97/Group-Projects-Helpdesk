<?php
//create.php
//Tom Snelling | Adam Morley

//this file accesses the database and creates a new ticket
//it populates the fields with the data entered by the user and adds the tags to a seperate table
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

	$table_tickets = "Tickets";
	
	//get data entered by user and set to appropriate variables
	$first_name = $_GET['firstname'];
	$last_name = $_GET['lastname'];
	$email = $_GET['email'];
	$specialist = $_GET['specialist'];
	$type = $_GET['type'];
	$problem_type = $_GET['problemtype'];
	$summary = $_GET['summary'];
	$details = $_GET['details'];
	$followup = $_GET['followup'];
	$operator = $_GET['operator'];
	$hwserial = $_GET['hwserial'];
	$osname = $_GET['osname'];
	$swname = $_GET['swname'];
	$swversion = $_GET['swversion'];
	$swlicense = $_GET['swlicense'];
	$tags = $_GET['tags'];
	$status = $_GET['status'];

	//SQL to enter data into corrrect fields
	$sql = "INSERT INTO $table_tickets (callerfirstname, callerlastname, specialist, type, summary, details, operator, email, followup, hwserial, osname, swname, swversion, swlicense, problemtype, status) VALUES ('$first_name', '$last_name', '$specialist', '$type', '$summary', '$details', '$operator', '$email', '$followup', '$hwserial', '$osname', '$swname', '$swversion', '$swlicense', '$problem_type', '$status')";
	
	//execute SQL
    if(!$conn->query($sql)) {
        echo "Failed to save data: (" . $conn->connect_errno . ") " . $conn->connect_error;
    }

	//SQL to get id of ticket just created
	//newest ticket will be first result
	$sql = "SELECT id FROM Tickets";
	
	//query database
    if($res = $conn->query($sql)) {
        while ($row = $res->fetch_row()) {
            //store top result in variable
            $id = $row[0];
        }
    }

	$table = 'Tags';	

	//split tag string into array
	//create new element of array around each comma and populate with following string
	$tagarray = explode(',', $tags);
	//calculate amount of tags entered
	$length = count($tagarray) - 1;

	//for each tag
	for($x = 0; $x <= $length; $x++) {
		//remove any spaces in string
		$tagarray[$x] = str_replace(' ', '', $tagarray[$x]);
	}
	
	//SQL to enter each tag into database with associated id
	$sql = "INSERT INTO $table (id, tag) VALUES ('$id', '$tagarray[0]')";
	
	//for each tag after the first
	for($y = 1; $y <= $length; $y++) {
		//concatenate sql to add each tag to sql statement
		$sql = $sql . ", ('$id', '$tagarray[$y]')";
	}
	//execute SQL
    if(!$conn->query($sql)) {
        echo "Failed to save data: (" . $conn->connect_errno . ") " . $conn->connect_error;
    }
    else {
        echo "OK";
    }

    mysqli_close($conn);

?>