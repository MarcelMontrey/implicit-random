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
var order = ["ran", "det"];
var training = "left";
var trial = 0;
var streak = 0;

// Debug.
current--;

randColors();
nextPage();

function randColors() {
	var randHTML = document.getElementById("left-machine").innerHTML;
	var detHTML = document.getElementById("right-machine").innerHTML;
	if(Math.random() < 0.5) {
		order = order.reverse();
		document.getElementById("left-machine").innerHTML = detHTML;
		document.getElementById("right-machine").innerHTML = randHTML;
	}
	
	if(Math.random() < 0.5) {
		colors = colors.reverse();
	}
	document.getElementById("ran-div").className = colors[0];
	document.getElementById("det-div").className = colors[1];
	document.getElementById("ran-img").src = "images/" + colors[0] + "_default.png";
	document.getElementById("det-img").src = "images/" + colors[1] + "_default.png";
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
	document.getElementById("right-machine").style.opacity = 0.25;
	document.getElementById(order[1] + "-btn").disabled = true;
}

function startTrials() {
	document.getElementById("trial-title").innerHTML = "Round 1/" + N_TRIALS;
}

function pullRan() {
	document.getElementById("ran-img").src = "images/" + colors[0] + "_active.png";
	pullEither();
	if(Math.random() < PROB_RAND) {
		setTimeout(function() {
			document.getElementById("ran-img").src = "images/" + colors[0] + "_won.png";
		}, DELAY_RESULT);
	}
	else {
		setTimeout(function() {
			document.getElementById("ran-img").src = "images/" + colors[0] + "_lost.png";
		}, DELAY_RESULT);
	}
}

function pullDet() {
	document.getElementById("det-img").src = "images/" + colors[1] + "_active.png";
	pullEither();
	if(Math.random() < PROB_DET || streak == MAX_LOSS) {
		setTimeout(function() {
			document.getElementById("det-img").src = "images/" + colors[1] + "_won.png";
		}, DELAY_RESULT);
		
		streak = 0;
	}
	else {
		setTimeout(function() {
			document.getElementById("det-img").src = "images/" + colors[1] + "_lost.png";
		}, DELAY_RESULT);
		
		streak++;
	}
}

function pullEither() {
	document.getElementById("ran-btn").disabled = true;
	document.getElementById("det-btn").disabled = true;
	setTimeout(function() {
		nextRound();
	}, DELAY_RESULT + DELAY_ROUND);
}

function nextRound() {
	trial++;
	if(training == "left") {
		if(trial < N_TRAINING) {
			document.getElementById(order[0] + "-btn").disabled = false;
			document.getElementById(order[0] + "-img").src = "images/" + colors[0] + "_default.png";
		}
		else {
			trial = 0;
			training = "right";
			document.getElementById(order[1] + "-btn").disabled = false;
			document.getElementById(order[0] + "-btn").disabled = true;
			document.getElementById(order[0] + "-img").src = "images/" + colors[0] + "_default.png";
			document.getElementById("left-machine").style.opacity = 0.25;
			document.getElementById("right-machine").style.opacity = 1;
		}
		document.getElementById("trial-title").innerHTML = "Round " + (trial + 1) + "/" + N_TRAINING;
	}
	else if(training = "right") {
		if(trial < N_TRAINING) {
			document.getElementById(order[1] + "-btn").disabled = false;
			document.getElementById(order[1] + "-img").src = "images/" + colors[1] + "_default.png";
		}
		else {
			trial = 0;
			training = "done";
			document.getElementById(order[1] + "-btn").disabled = false;
			document.getElementById(order[0] + "-btn").disabled = false;
			document.getElementById(order[0] + "-img").src = "images/" + colors[0] + "_default.png";
			document.getElementById(order[1] + "-img").src = "images/" + colors[1] + "_default.png";
			document.getElementById("left-machine").style.opacity = 1;
			document.getElementById("right-machine").style.opacity = 1;
		}
		document.getElementById("trial-title").innerHTML = "Round " + (trial + 1) + "/" + N_TRAINING;
	}
	else if(training == "done" && trial < N_TRIALS) {
		document.getElementById("trial-title").innerHTML = "Round " + (trial + 1) + "/" + N_TRIALS;
		document.getElementById("ran-btn").disabled = false;
		document.getElementById("det-btn").disabled = false;
		document.getElementById("ran-img").src = "images/" + colors[0] + "_default.png";
		document.getElementById("det-img").src = "images/" + colors[1] + "_default.png";
	}
	else {
		nextPage();
	}
}
</script>
</body>
</html>