<div class="page" id="4-preference">
	<div class="title">Preference</div>

	<div class="content center">
		<p>Which of the two machines did you prefer?<br>
		<select id="sel-preference" onclick="checkPref()">
			<option value=""></option>
			<option value="left">Left machine</option>
			<option value="right">Right machine</option>
			<option value="none">Neither / I don't know</option>
		</select></p>
		
		<p>If you preferred a machine, which of these statements (if any) describe why?<br>
			<input type="checkbox" id="check-win" disabled>More likely to win</input><br>
			<input type="checkbox" id="check-lucky" disabled>Had better luck playing it</input><br>
			<input type="checkbox" id="check-winstreak" disabled>Longer or more frequent winning streaks</input><br>
			<input type="checkbox" id="check-losestreak" disabled>Shorter or less frequent losing streaks</input><br>
			<input type="checkbox" id="check-other" disabled>Other:</input>
			<input type="textbox" id="other-txt" disabled></input>
		</p>
	</div>
	
	<div class="next">
		<button onclick="nextPage()" id="pref-next" disabled>Next</button>
	</div>
</div>