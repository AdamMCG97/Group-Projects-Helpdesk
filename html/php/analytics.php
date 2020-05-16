<?php
//analytics.php
//Adam Morley

//this file accesses the database with multiple SQL queries to obtain data used on the analytics page
//various datasets from different tables are loaded and manipulated here
//it outputs the results in an array
//this file is called from view-analytics.js
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

    $allQuerysReturnRes = true;

	$table = "Tickets";
	
	//SQL query to gather various data from various tables, each given appropriate names for their row
	$sql = "SELECT (SELECT Count(*) 
        FROM   $table 
        WHERE  status = 'pending' 
                OR status = 'ongoing') AS 'tot_open', 
       (SELECT Count(*) 
        FROM   $table 
        WHERE  status = 'solved')      AS 'tot_closed', 
       (SELECT Count(*) 
        FROM   specialists)            AS 'tot_specialists', 
       (SELECT Count(*) 
        FROM   $table 
        WHERE  type = 'Hardware')      AS 'tot_hardware', 
       (SELECT Count(*) 
        FROM   $table 
        WHERE  type = 'Software')      AS 'tot_software', 
       (SELECT Count(*) 
        FROM   $table 
        WHERE  status = 'pending' 
               AND archived = '0')     AS 'tot_pending', 
       (SELECT Count(*) 
        FROM   $table 
        WHERE  status = 'ongoing' 
               AND archived = '0')     AS 'tot_ongoing', 
       (SELECT Count(*) 
        FROM   $table 
        WHERE  status = 'solved' 
               AND archived = '0')     AS 'tot_solved', 
       (SELECT Count(*) 
        FROM   users 
        WHERE  type = 'Specialist' 
               AND available = '0')    AS 'tot_unavailable', 
       (SELECT Count(*) 
        FROM   tags)                   AS 'tot_tags', 
       (SELECT Count(*) 
        FROM   tickets 
        WHERE  archived = '0')         AS tot_notarchived";

	//query database
	if($res = $conn->query($sql)) {

        if ($res->num_rows > 0) {

            while ($row = $res->fetch_row()) {
                //store query results in appropriate variables
                $totalopen = $row[0];
                $totalclosed = $row[1];
                $totalspecialists = $row[2];
                $totalhardware = $row[3];
                $totalsoftware = $row[4];
                $totalpending = $row[5];
                $totalongoing = $row[6];
                $totalsolved = $row[7];
                $totalunavailable = $row[8];
                $totaltags = $row[9];
                $totalnotarchived = $row[10];
            }
        }
/*        else {
            $allQuerysReturnRes = false;
        }*/
    }

	//SQL query to gather various data from various tables
	$sql = "SELECT Resolvedtickets.timestamp, Tickets.timestamp, Tickets.id FROM Resolvedtickets JOIN Tickets WHERE Resolvedtickets.id = Tickets.id";

	//query database
    if($res = $conn->query($sql)) {

        if ($res->num_rows > 0) {

            while ($row = $res->fetch_row()) {
                //store query results in appropriate variables
                $resolvedtime = strtotime($row[0]);
                $createdtime = strtotime($row[1]);
                $id = $row[2];
                $time = $resolvedtime - $createdtime;
                $avgtime = $avgtime + $time;
                $avgcount = $avgcount + 1;
            }
        }
/*        else {
            $allQuerysReturnRes = false;
        }*/
    }
 /*   else {
        $allQuerysReturnRes = false;
    }*/

	//SQL query to gather various data from various tables
	$sql = "SELECT 
       ( 
                SELECT   Count(*) 
                FROM     resolvedtickets 
                JOIN     users 
                where    resolvedtickets.solvedby = users.username 
                AND      users.type = 'Specialist' 
                GROUP BY users.type
		) AS specialistsolve, 
       ( 
                SELECT   count(*) 
                FROM     resolvedtickets 
                JOIN     users 
                WHERE    resolvedtickets.solvedby = users.username 
                AND      users.type = 'Operator' 
                GROUP BY users.type
		) AS operatorsolve";
	
	//query database
    if($res = $conn->query($sql)) {

        if ($res->num_rows > 0) {

            while ($row = $res->fetch_row()) {
                //store query results in appropriate variables
                $specialistsolve = $row[0];
                $operatorsolve = $row[1];
                //if no result set to 0
                if ($specialistsolve == null) {
                    $specialistsolve = 0;
                }
                if ($operatorsolve == null) {
                    $operatorsolve = 0;
                }
            }
        }
/*        else {
            $allQuerysReturnRes = false;
        }*/
    }
/*    else {
        $allQuerysReturnRes = false;
    }*/

    mysqli_close($conn);

        //data manipulation
        $total = $totalopen + $totalclosed;
        $softwarepercent = round(($totalsoftware / $total) * 100);

        $totalavailable = $totalspecialists - $totalunavailable;
        $availablepercent = round(($totalavailable / $totalspecialists) * 100);

        $totalresolved = $specialistsolve + $operatorsolve;

        //convert average time in seconds to hours and minutes
        $avg = $avgtime / $avgcount;
        $avghour = floor($avg / 3600);
        $avgmin = round(($avg - ($avghour * 3600)) / 60);
        if ($avgmin < 10) {
            $avgmin = '0' . $avgmin;
        }
        $displayavg = $avghour . 'h' . $avgmin . 'm';

        echo json_encode(array("total" => $total, "totalopen" => $totalopen, "totalclosed" => $totalclosed, "totalspecialists" => $totalspecialists, "softwarepercent" => $softwarepercent, "totalhardware" => $totalhardware, "totalpending" => $totalpending, "totalongoing" => $totalongoing, "totalsolved" => $totalsolved, "avg" => $displayavg, "specialistsolve" => $specialistsolve, "totalresolved" => $totalresolved, "operatorsolve" => $operatorsolve, "availablepercent" => $availablepercent, "totaltags" => $totaltags, "totalnotarchived" => $totalnotarchived));


?>