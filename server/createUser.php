<?php
require_once("User.php");

// Recover all of the user's identifying information from the POST request.
$startTime = $_REQUEST["startTime"];
$assignmentId = $_REQUEST["assignmentId"];
$hitId = $_REQUEST["hitId"];
$workerId = $_REQUEST["workerId"];
$ip = $_REQUEST["ip"];

// Create the user.
User::create($startTime, $assignmentId, $hitId, $workerId, $ip);
?>
