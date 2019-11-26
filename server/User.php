<?php
require_once("params.php");
require_once("Util.php");

class User {

	// Create the directory and file structure for handling our data if it doesn't already exist.
	public static function createStructure() {
		// Is there a users directory?
		if(!file_exists(dirname(__FILE__) . "/../users")) {
			mkdir(dirname(__FILE__) . "/../users");
		}

		// Is there a directory for dropouts?
		if(!file_exists(dirname(__FILE__) . "/../users/dropouts")) {
			mkdir(dirname(__FILE__) . "/../users/dropouts");
		}

		// Is there a directory for each condition?
		if(!file_exists(dirname(__FILE__) . "/../users/participants")) {
			mkdir(dirname(__FILE__) . "/../users/participants");
		}
	}

	// Create a file storing a new user's information.
	public static function create($startTime, $assignmentId, $hitId, $workerId, $ip) {
		// Output we're going to write.
		$str = "";

		// User's identifying information.
		$str .= "\n\n" . "[identity]";
		$str .= "\n" . "startTime=" . $startTime;
		$str .= "\n" . "assignmentId=" . $assignmentId;
		$str .= "\n" . "hitId=" . $hitId;
		$str .= "\n" . "workerId=" . $workerId;
		$str .= "\n" . "ip=" . $ip;

		// Open a file pointer for writing.
		$fpOut = fopen(dirname(__FILE__) . "/../users/participants/" . $workerId . ".txt", "w");

		// Write the output to the file.
		fwrite($fpOut, $str);

		// Close the file pointer.
		fclose($fpOut);
	}

	// Append the submitted data to the user's file.
	public static function submit($workerId, $order, $colors, $choices, $outcomes, $winnings, $pref, $description, $randomness, $demo, $duration, $surveyCode) {
		// Output we're going to write.
		$str = "";

		// User's output. Already parsed into a string, since we're getting it from the client.
		$str .= "\n\n" . "[output]";
		$str .= "\n" . "order=" . $order;
		$str .= "\n" . "colors=" . $colors;
		$str .= "\n" . "choices=" . $choices;
		$str .= "\n" . "outcomes=" . $outcomes;
		$str .= "\n" . "winnings=" . $winnings;

		// Details about the user's performance, the survey code they received, time they spent, etc.
		$str .= "\n\n" . "[survey]";
		$str .= "\n" . "pref=" . $pref;
		$str .= "\n" . "description=" . $description;
		$str .= "\n" . "randomness=" . $randomness;
		$str .= "\n" . "demo=" . $demo;
		
		$str .= "\n\n" . "[details]";
		$str .= "\n" . "duration=" . $duration;
		$str .= "\n" . "surveyCode=" . $surveyCode;

		// Append everything to the correct file.
		Util::appendToFile(dirname(__FILE__) . "/../users/participants/" . $workerId . ".txt", $str);
	}

	// Load all user records.
	public static function loadAll() {
		$users = array();

		// Create a directory iterator over the dropouts folder.
		$dir = new DirectoryIterator(dirname(__FILE__) . "/../users/participants");

		// Load each user's record that's saved in the participants folder.
		foreach ($dir as $fileinfo) {
			// Make sure it's a file, not a directory.
			if($fileinfo->isFile()) {
				array_push($users, User::loadFromFile(dirname(__FILE__) . "/../users/participants/" . $fileinfo->getFilename()));
			}
		}

		return $users;
	}

	// Load a particular user's record.
	public static function load($workerId) {
		return User::loadFromFile(dirname(__FILE__) . "/../users/participants/" . $workerId . ".txt");
	}

	// Load all dropouts' user records.
	public static function loadDropouts() {
		$users = array();

		// Create a directory iterator over the dropouts folder.
		$dir = new DirectoryIterator(dirname(__FILE__) . "/../users/dropouts");

		// Load each user's record that's saved in the dropouts folder.
		foreach ($dir as $fileinfo) {
			// Make sure it's a file, not a directory.
			if($fileinfo->isFile()) {
				array_push($users, User::loadFromFile(dirname(__FILE__) . "/../users/dropouts/" . $fileinfo->getFilename()));
			}
		}

		return $users;
	}

	// Return an array containing a particular user's information, loading the file from a path.
	public static function loadFromFile($file) {
		// Store the user's record in an array.
		$user = array();

		// Make sure the file exists.
		if(file_exists($file)) {
			// Open a file pointer for reading.
			$fpIn = fopen($file, "r");

			// Loop over every line of the file.
			while(!feof($fpIn)) {
				// Trim whitespace when grabbing the next line.
				$line = trim(fgets($fpIn));

				// Only bother with lines that store a value.
				if(substr_count($line, "=") > 0) {
					$pos = strpos($line, "="); // Position of the delimiter between the variable name and value.
					$var = substr($line, 0, $pos); // Variable name.
					$value = substr($line, $pos + 1); // Variable value.

					// Load the variable, parsing it into a one or two-dimensional array, depending on whether the semicolon and comma delimiters are used.
					$user[$var] = Util::str2Array($value);
				}
			}

			// Close the file pointer.
			fclose($fpIn);
		}

		return $user;
	}
}

?>
