<?php
//userAnalytics.php
//Adam Morley | Tom Snelling

//this file accesses the database to calculate select information on each specialist and output the results in an array
//this file is called from specialist-analytics.js, create-issue.js
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

	$table = "Tickets";

	//SQL to select ticket and user information for each specialist including returning the user when no data exists
	$sql = "
	SELECT a.closed, 
       b.open, 
       a.username, 
       firstname, 
       lastname, 
       available 
	FROM   (SELECT Count(tickets.id) AS 'closed', 
               specialists.username 
        FROM   specialists 
               left join tickets 
                      ON specialists.username = tickets.specialist 
                         AND status = 'solved' 
        GROUP  BY specialists.username) AS a 
       left join (SELECT Count(tickets.id) AS 'open', 
                         specialists.username 
                  FROM   specialists 
                         left join tickets 
                                ON specialists.username = tickets.specialist 
                                   AND ( status = 'pending' 
                                          OR status = 'ongoing' ) 
                  GROUP  BY specialists.username) AS b 
              ON a.username = b.username 
       join users 
         ON a.username = users.username";

	$allData = Array();

	//execute sql
	if($res = $conn->query($sql)) {
		while ($row = $res->fetchRow()) {
			//store results as appropriate variables
			$closedtickets = $row[0];
			$opentickets = $row[1];
			$specialist = $row[2];
			$name = $row[3] . ' ' . $row[4];
			$available = $row[5];
			//if no results for ticket counts set to 0
			if ($closedtickets == null) {
				$closedtickets = 0;
			}

			if ($opentickets == null) {
				$opentickets = 0;
			}
			//store variables in array
			array_push($allData, array("closedtickets" => $closedtickets, "specialist" => $specialist, "opentickets" => $opentickets, "name" => $name, "available" => $available));
		}
	}
	//output results
	echo json_encode($allData);

	mysqli_close($conn);

?>

