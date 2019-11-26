<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="random.css">
</head>
<body>

<?php include("pages/1-consent.php"); ?>
<?php include("pages/2-instructions.php"); ?>
<?php include("pages/3-trial.php"); ?>
<?php include("pages/4-preference.php"); ?>
<?php include("pages/5-randomness.php"); ?>
<?php include("pages/6-demographics.php"); ?>
<?php include("pages/7-code.php"); ?>

<script type="text/javascript">
const N_TRAINING = 3;
const N_TRIALS = 5;
const PROB_RAND = 0.167;
const PROB_DET = 0.08;
const MAX_LOSS = 4;
const DELAY_RESULT = 500;
const DELAY_ROUND = 1000;

var current = 2;
var pages = ["1-consent", "2-instructions", "3-trial", "4-preference", "5-randomness", "6-demographics", "7-code"];
var colors = ["blue", "purple"];
var order = ["rand", "det"];
var training = "left";
var trial = 0;
var streak = 0;

// Debug.
current--;

randColors();
nextPage();

function randColors() {
	// Randomize the left-right order of the random and deterministic machines.
	if(Math.random() < 0.5) {
		order = order.reverse();
	}
	
	// Randomize the machine color.
	if(Math.random() < 0.5) {
		colors = colors.reverse();
	}
	
	document.getElementById("left-div").className = colors[0];
	document.getElementById("right-div").className = colors[1];
	document.getElementById("left-img").src = "images/" + colors[0] + "_default.png";
	document.getElementById("right-img").src = "images/" + colors[1] + "_default.png";
}

function nextPage() {
	document.getElementById(pages[current]).style.display = "none";
	document.getElementById(pages[current + 1]).style.display = "block";
	current++;
	
	if(pages[current] == "3-trial") {
		startTraining();
	}
}

function startTraining() {
	document.getElementById("trial-title").innerHTML = "Round 1/" + N_TRAINING;
	document.getElementById("right-div").style.opacity = 0.25;
	document.getElementById("right-btn").disabled = true;
}

function startTrials() {
	document.getElementById("trial-title").innerHTML = "Round 1/" + N_TRIALS;
}

function pullLever(machine) {
	var side = (machine == 0) ? "left" : "right";
	
	document.getElementById(side + "-img").src = "images/" + colors[machine] + "_active.png";
	
	// Disable both buttons.
	document.getElementById("left-btn").disabled = true;
	document.getElementById("right-btn").disabled = true;
	
	var outcome = "";
	// Check if the machine is the random or the deterministic one.
	if(order[machine] == "rand") {
		// Check if the user won or lost.
		if(Math.random() < PROB_RAND) {
			outcome = "won";
		}
		else {
			outcome = "lost";
		}
	}
	else if(order[machine] == "det") {
		// Check if the user won or lost. Reset their losing streak if they won.
		if(Math.random() < PROB_DET || streak == MAX_LOSS) {
			outcome = "won";
			streak = 0;
		}
		else {
			outcome = "lost";
			streak++;
		}
	}
	
	// Show the game's outcome, after an appropriate delay.
	setTimeout(function() {
		document.getElementById(side + "-img").src = "images/" + colors[machine] + "_" + outcome + ".png";
	}, DELAY_RESULT);
	
	// Move on to the next round, after an even longer delay.
	setTimeout(function() {
		nextRound();
	}, DELAY_RESULT + DELAY_ROUND);
}

function nextRound() {
	trial++;
	if(training == "left") {
		if(trial < N_TRAINING) {
			document.getElementById("left-btn").disabled = false;
			document.getElementById("left-img").src = "images/" + colors[0] + "_default.png";
		}
		else {
			trial = 0;
			training = "right";
			document.getElementById("right-btn").disabled = false;
			document.getElementById("left-btn").disabled = true;
			document.getElementById("left-img").src = "images/" + colors[0] + "_default.png";
			document.getElementById("left-div").style.opacity = 0.25;
			document.getElementById("right-div").style.opacity = 1;
		}
		document.getElementById("trial-title").innerHTML = "Round " + (trial + 1) + "/" + N_TRAINING;
	}
	else if(training == "right") {
		if(trial < N_TRAINING) {
			document.getElementById("right-btn").disabled = false;
			document.getElementById("right-img").src = "images/" + colors[1] + "_default.png";
		}
		else {
			trial = 0;
			training = "done";
			document.getElementById("left-btn").disabled = false;
			document.getElementById("right-btn").disabled = false;
			document.getElementById("right-img").src = "images/" + colors[1] + "_default.png";
			document.getElementById("left-div").style.opacity = 1;
		}
		document.getElementById("trial-title").innerHTML = "Round " + (trial + 1) + "/" + N_TRAINING;
	}
	else if(training == "done" && trial < N_TRIALS) {
		document.getElementById("trial-title").innerHTML = "Round " + (trial + 1) + "/" + N_TRIALS;
		document.getElementById("left-btn").disabled = false;
		document.getElementById("right-btn").disabled = false;
		document.getElementById("left-img").src = "images/" + colors[0] + "_default.png";
		document.getElementById("right-img").src = "images/" + colors[1] + "_default.png";
	}
	else {
		nextPage();
	}
}
</script>
</body>
</html>