<?php
require_once("User.php");
require_once("Util.php");
require_once("params.php");

// Create the user data directory and file structure if it doesn't already exist.
User::createStructure();

// Recover our user's identifying information.
$startTime = time();
$assignmentId = isset($_REQUEST["assignmentId"]) ? $_REQUEST["assignmentId"] : null;
$hitId = isset($_REQUEST["hitId"]) ? $_REQUEST["hitId"] : null;
$workerId = isset($_REQUEST["workerId"]) ? $_REQUEST["workerId"] : null;
$ip = getIP();

// Make sure the user is valid.
$valid = isValid($startTime, $assignmentId, $hitId, $workerId, $ip);

// Get the user's IP address.
function getIP() {
	if(!empty($_SERVER['HTTP_CLIENT_IP'])) {
		$ip = $_SERVER['HTTP_CLIENT_IP'];
	}
	elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
		$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	}
	else {
		$ip = $_SERVER['REMOTE_ADDR'];
	}

	return $ip;
}

// Return whether or not the user is valid (did we get an assignmentId, hitId and workerId, and did the workerId not match any existing user or dropout?)
function isValid($startTime, $assignmentId, $hitId, $workerId, $ip) {
	// If one of our variables isn't set, they didn't accept the HIT properly, so kick them out.
	if(!isset($assignmentId, $hitId, $workerId, $ip) || empty($assignmentId) || empty($hitId) || empty($workerId)) {
		return -1;
	}

	// Load all user records.
	$users = User::loadAll();

	// Compare our workerId against each existing user's.
	for($i = 0; $i < count($users); $i++) {
		// If the user already participated, add them to our list of rejects and kick them out.
		if($users[$i]["workerId"] == $workerId) {
			Util::appendToFile(dirname(__FILE__) . "/../users/rejected.log", implode("\t", array($startTime, $assignmentId, $hitId, $workerId, $ip)) . "\n");
			return 0;
		}
	}

	// Load our dropouts' records.
	$dropouts = User::loadDropouts();

	// Compare our workerId against each dropout's.
	for($i = 0; $i < count($dropouts); $i++) {
		// If the dropout already participated, add them to our list of rejects and kick them out.
		if($dropouts[$i]["workerId"] == $workerId) {
			Util::appendToFile(dirname(__FILE__) . "/../users/rejected.log", implode("\t", array($startTime, $assignmentId, $hitId, $workerId, $ip)) . "\n");
			return 0;
		}
	}

	// If we haven't found any problems, add the user to our list of accepted participants and return valid.
	Util::appendToFile(dirname(__FILE__) . "/../users/accepted.log", implode("\t", array($startTime, $assignmentId, $hitId, $workerId, $ip)) . "\n");
	return 1;
}

?>
