<?php
require_once("User.php"); // Used to save user's output to their file.

// Figure out which user's data we're handling.
$condition = $_REQUEST["condition"];
$cohort = $_REQUEST["cohort"];
$position = $_REQUEST["position"];
$number = $_REQUEST["number"];

// Retrieve the data they submitted.
$pre = $_REQUEST["pre"];
$post = $_REQUEST["post"];
$chosen = $_REQUEST["chosen"];
$chosenInput = $_REQUEST["chosenInput"];
$useMachine = $_REQUEST["useMachine"];
$output = $_REQUEST["output"];
$score = $_REQUEST["score"];
$totalTime = $_REQUEST["totalTime"];
$gameTime = $_REQUEST["gameTime"];
$surveyCode = $_REQUEST["surveyCode"];

// Append the submitted data to the user's file.
User::submit($workerId, $order, $colors, $choices, $outcomes, $winnings, $pref, $description, $randomness, $demo, $duration, $surveyCode);
?>
