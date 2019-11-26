<div class="page" id="6-demographics">
	<div class="title">Demographics</div>
	
	<div class="content center">
		<p>Please answer the questions below to be assigned to one of two groups (<span class="red">red</span> or <span class="blue">blue</span>).</p>
	</div>

	<div class="content center">
		<p>
			What is your country of residence?<br>
			<select id="demo-country" onclick="checkDemo()">
				<option value="none"></option>
				<option value="USA">United States</option>
				<option value="none">---</option>
				<?php
					$countries = array("Afghanistan","Albania","Algeria","American Samoa","Andorra","Angola","Anguilla","Antigua and Barbuda","Argentina","Armenia","Aruba","Australia","Austria","Azerbaijan","Bahamas","Bahrain","Bangladesh","Barbados","Belarus","Belgium","Belize","Benin","Bermuda","Bhutan","Bolivia","Bosnia and Herzegowina","Botswana","Bouvet Island","Brazil","Brunei Darussalam","Bulgaria","Burkina Faso","Burundi","Cambodia","Cameroon","Canada","Cape Verde","Cayman Islands","Central African Republic","Chad","Chile","China","Christmas Island","Cocos (Keeling) Islands","Colombia","Comoros","Congo","Cook Islands","Costa Rica","Cote D'Ivoire","Croatia","Cuba","Cyprus","Czech Republic","Denmark","Djibouti","Dominica","Dominican Republic","East Timor","Ecuador","Egypt","El Salvador","Equatorial Guinea","Eritrea","Estonia","Ethiopia","Falkland Islands","Faroe Islands","Fiji","Finland","France","French Guiana","French Polynesia","Gabon","Gambia","Georgia","Germany","Ghana","Gibraltar","Greece","Greenland","Grenada","Guadeloupe","Guam","Guatemala","Guinea","Guinea-bissau","Guyana","Haiti","Heard and Mc Donald Islands","Honduras","Hong Kong","Hungary","Iceland","India","Indonesia","Iran","Iraq","Ireland","Israel","Italy","Jamaica","Japan","Jordan","Kazakhstan","Kenya","Kiribati","Korea, Democratic People's Republic of","Korea, Republic of","Kuwait","Kyrgyzstan","Lao People's Democratic Republic","Latvia","Lebanon","Lesotho","Liberia","Libyan Arab Jamahiriya","Liechtenstein","Lithuania","Luxembourg","Macau","Macedonia","Madagascar","Malawi","Malaysia","Maldives","Mali","Malta","Marshall Islands","Martinique","Mauritania","Mauritius","Mayotte","Mexico","Micronesia, Federated States of","Moldova, Republic of","Monaco","Mongolia","Montserrat","Morocco","Mozambique","Myanmar","Namibia","Nauru","Nepal","Netherlands","Netherlands Antilles","New Caledonia","New Zealand","Nicaragua","Niger","Nigeria","Niue","Norfolk Island","Northern Mariana Islands","Norway","Oman","Pakistan","Palau","Panama","Papua New Guinea","Paraguay","Peru","Philippines","Pitcairn","Poland","Portugal","Puerto Rico","Qatar","Reunion","Romania","Russian Federation","Rwanda","Saint Kitts and Nevis","Saint Lucia","Saint Vincent and the Grenadines","Samoa","San Marino","Sao Tome and Principe","Saudi Arabia","Senegal","Seychelles","Sierra Leone","Singapore","Slovakia (Slovak Republic)","Slovenia","Solomon Islands","Somalia","South Africa","South Georgia and the South Sandwich Islands","Spain","Sri Lanka","St. Helena","St. Pierre and Miquelon","Sudan","Suriname","Svalbard and Jan Mayen Islands","Swaziland","Sweden","Switzerland","Syrian Arab Republic","Taiwan","Tajikistan","Tanzania, United Republic of","Thailand","Togo","Tokelau","Tonga","Trinidad and Tobago","Tunisia","Turkey","Turkmenistan","Turks and Caicos Islands","Tuvalu","Uganda","Ukraine","United Arab Emirates","United Kingdom","Uruguay","Uzbekistan","Vanuatu","Vatican City State (Holy See)","Venezuela","Vietnam","Virgin Islands (British)","Virgin Islands (U.S.)","Wallis and Futuna Islands","Western Sahara","Yemen","Yugoslavia","Zaire","Zambia","Zimbabwe");

					for($i = 0; $i < count($countries); $i++) {
						echo("\t\t\t\t<option value=\"" . $i . "\">" . $countries[$i] . "</option>\n");
					}
				?>
			</select>
		</p>

		<p>
			What is your age, in years?<br>
			<select id="demo-age" onclick="checkDemo()">
				<option value="none"></option>
				<?php
					for ($i = 18; $i < 100; $i++) {
						echo("\t\t\t\t<option value=\"" . $i . "\">" . $i . "</option>\n");
					}
				?>
			</select>
		</p>

		<p>
			What is your sex?<br>
			<select id="demo-sex" onclick="checkDemo()">
				<option value="none"></option>
				<option value="Male">Male</option>
				<option value="Female">Female</option>
			</select>
		</p>

		<p>
			What is your native language?<br>
			<select id="demo-lang" onclick="checkDemo()">
				<option value="none"></option>
				<?php
					$languages = array("English","Spanish","French","Mandarin","Hindi","Arabic","Portuguese","Bengali","Russian","Japanese","Punjabi","German","Javanese","Wu","Indonesian/Malay","Telugu","Vietnamese","Korean","Marathi","Tamil","Urdu","Turkish","Italian","Cantonese","Thai","Gujarati","Jin","Min Nan","Persian","Polish","Pashto","Kannada","Xiang","Malayalam","Sundanese","Hausa","Oriya","Burmese","Hakka","Ukrainian","Bhojpuri","Tagalog","Yoruba","Maithili","Uzbek","Sindhi","Amharic","Fula","Romanian","Oromo","Igbo","Azerbaijani","Awadhi","Gan Chinese","Cebuano","Dutch","Kurdish","Serbo-Croatian","Malagasy","Saraiki","Nepali","Sinhalese","Chittagonian","Zhuang","Khmer","Turkmen","Assamese","Madurese","Somali","Marwari","Magahi","Haryanvi","Hungarian","Chhattisgarhi","Greek","Chewa","Deccan","Akan","Kazakh","Min Bei","Sylheti","Zulu","Czech","Kinyarwanda","Dhundhari","Haitian Creole","Min Dong","Ilokano","Quechua","Kirundi","Swedish","Hmong","Shona","Uyghur","Hiligaynon","Mossi","Xhosa","Belarusian","Balochi","Konkani");

					for($i = 0; $i < count($languages); $i++) {
						echo("\t\t\t\t<option value=\"" . $i . "\">" . $languages[$i] . "</option>\n");
					}
				?>
			</select>
		</p>

		<p>
			What is the highest level of education that you have completed?<br>
			<small><i>(If currently enrolled, please select the previous grade or highest degree received.)</i></small><br>
			<select id="demo-edu" onclick="checkDemo()">
				<option value="none"></option>
				<option value="LHS">Less than High School</option>
				<option value="HS">High School/GED</option>
				<option value="College">Some College</option>
				<option value="Associates">2-Year College Degree (Associates)</option>
				<option value="BA-BS">4-Year College Degree (BA, BS)</option>
				<option value="MA-MS">Master's Degree (MA, MS)</option>
				<option value="PhD">Doctoral Degree (PhD)</option>
				<option value="MD-JD">Professional Degree (MD, JD)</option>
			</select>
		</p>
	</div>
	
	<div class="next">
		<button onclick="nextPage()" id="demo-next">Next</button>
	</div>
</div>