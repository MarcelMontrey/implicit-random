<?php
require_once("User.php"); // Used to save user's output to their file.

// Figure out which user's data we're handling.
$workerId = $_REQUEST["workerId"];

// Retrieve the data they submitted.
$order = $_REQUEST["pre"];
$colors = $_REQUEST["pre"];
$choices = $_REQUEST["pre"];
$outcomes = $_REQUEST["pre"];
$winnings = $_REQUEST["pre"];
$pref = $_REQUEST["pre"];
$description = $_REQUEST["pre"];
$randomness = $_REQUEST["pre"];
$demo = $_REQUEST["pre"];
$duration = $_REQUEST["pre"];
$surveyCode = $_REQUEST["pre"];

// Append the submitted data to the user's file.
User::submit($workerId, $order, $colors, $choices, $outcomes, $winnings, $pref, $description, $randomness, $demo, $duration, $surveyCode);
?>
