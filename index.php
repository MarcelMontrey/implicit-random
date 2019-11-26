<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="random.css">
</head>
<body>

<?php include("server/launch.php"); ?>

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

var startTime = <?php echo($startTime); ?>; // Start time.
var assignmentId = "<?php echo($assignmentId); ?>"; // assignmentId via POST.
var hitId = "<?php echo($hitId); ?>"; // hitId via POST.
var workerId = "<?php echo($workerId); ?>"; // workerId via POST.
var ip = "<?php echo($ip); ?>"; // IP address.
var valid = <?php echo($valid); ?>; // -1 if the above weren't passed by POST. 0 if the workerId belongs to an existing participant or a dropout. 1 otherwise.

var current = 0;
var pages = ["1-consent", "2-instructions", "3-trial", "4-preference", "5-randomness", "6-demographics", "7-code"];
var colors = ["blue", "purple"];
var order = ["rand", "det"];
var training = "";
var trial = 0;
var streak = 0;

var choices = [];
var outcomes = [];
var winnings = 0;

randColors();
document.getElementById(pages[0]).style.display = "block";

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
		createRecord();
		startTraining();
	}
	else if(pages[current] == "7-code") {
		submitData();
	}
}

function createRecord() {
	// Create a request to the server.
	var xhttp = new XMLHttpRequest();

	// Prepare the data we want to send when creating the user.
	var str = "";
	str += "startTime=" + startTime;
	str += "&assignmentId=" + assignmentId;
	str += "&hitId=" + hitId;
	str += "&workerId=" + workerId;
	str += "&ip=" + ip;

	// Send this data to the server, so it can create the user and send us back our condition, cohort, position and group.
	xhttp.open("POST", "server/createUser.php", true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send(str);
}

function startTraining() {
	training = "left";
	document.getElementById("trial-title").innerHTML = "Round 1/" + N_TRAINING;
	document.getElementById("right-div").style.opacity = 0.25;
	document.getElementById("right-btn").disabled = true;
	document.getElementById("middle-div").innerHTML = "<p>Try the machine on the left!</p>";
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
		if(training == "done") {
			choices[trial] = machine;
			outcomes[trial] = (outcome == "won") ? 1 : 0;
			winnings += (outcome == "won") ? 1 : 0;
			
			document.getElementById("middle-div").innerHTML = "<p>Total winnings: " + winnings + "</p>";
		}
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
			document.getElementById("middle-div").innerHTML = "<p>Try the machine on the right!</p>";
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
			document.getElementById("middle-div").innerHTML = "<p>Total winnings: 0</p>";
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

function checkPref() {
	var value = document.getElementById("sel-preference").value;
	if(value == "") {
		document.getElementById("pref-next").disabled = true;
	}
	else {
		document.getElementById("pref-next").disabled = false;
	}
	
	if(value == "left" || value == "right") {
		document.getElementById("check-win").disabled = false;
		document.getElementById("check-lucky").disabled = false;
		document.getElementById("check-winstreak").disabled = false;
		document.getElementById("check-losestreak").disabled = false;
		document.getElementById("check-other").disabled = false;
		document.getElementById("other-txt").disabled = false;
	}
	else {
		document.getElementById("check-win").disabled = true;
		document.getElementById("check-lucky").disabled = true;
		document.getElementById("check-winstreak").disabled = true;
		document.getElementById("check-losestreak").disabled = true;
		document.getElementById("check-other").disabled = true;
		document.getElementById("other-txt").disabled = true;
	}
}

function checkRand() {
	document.getElementById("rand-next").disabled = (document.getElementById("sel-rand").value == "") ? true : false;
}

// Submit the user's data.
function submitData() {
	// Prepare the data we want to send.
	var str = "";

	// User's output.
	str += "&workerId=" + workerId;
	str += "&order=" + order.toString();
	str += "&colors=" + colors.toString();
	str += "&choices=" + choices.toString();
	str += "&outcomes=" + outcomes.toString();
	str += "&winnings=" + winnings;
	
	str += "&pref=" + document.getElementById("sel-preference").value;
	str += "&description=" + "";
	str += "&randomness=" + document.getElementById("sel-randomness").value;;
	str += "&demo=" + "";
	
	str += "&duration=" + Math.round(new Date().getTime() / 1000 - startTime);
	str += "&surveyCode=" + surveyCode;

	// Create a request to the server.
	var xhttp = new XMLHttpRequest();

	// Submit our data to the server.
	xhttp.open("POST", "server/submitData.php", true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send(str);

	// The user is done, so remove the warning when navigating away from the page, stop preventing them from backing into the page, and clear the HIT timeout.
	/*window.onbeforeunload = null;
	window.localStorage.clear();
	clearTimeout(timeout);*/
}

// Copy the survey code to the user's clipboard for them.
function copyCode() {
	document.getElementById("survey-code").select();
	document.execCommand("copy");
}

</script>
</body>
</html>