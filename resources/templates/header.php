<div id="topbar">
	<div id="contentTopBar">
		<h1>Lecturate</h1>
		<img id="logo" src="img/logo.png" alt="DHBW-Logo">
		<p>Bewerten, Verbessern, Profitieren!</p>
	</div>
	<div id="background"></div>
</div>
<div id="navbar">
	<div id="left">
		<?php
		if (array_key_exists("login", $_SESSION)) {
			echo T::iconButton(false, "Admin", "admin");
			echo T::iconButton(false, "Vorlesung", "lecture");
			echo T::iconButton(false, "Dozent", "docent");
			echo T::iconButton(false, "SGL", "advisor");
			echo T::iconButton(false, "Kurs", "classs");
			echo T::iconButton(false, "Dozent hält Vorlesung", "docent_lecture");
			echo T::iconButton(false, "Kurs hört gehaltene Vorlesung", "classs_docent_lecture");
			echo T::iconButton(false, "Einmal-PW", "otpw");
			echo T::iconButton(false, "Bewertung", "rating");
			echo T::iconButton(false, "Auswertung", "evaluation");
		} else {
			echo T::iconButton(false, "Bewerten", "student");
		}
		?>
	</div>
	<div id="right">
		<?php 
		if (array_key_exists("login", $_SESSION))
			echo T::iconButton(false, "Abmelden", "advisor", "logout");
		else
			echo T::iconButton(false, "Anmelden", "advisor", "login");
		?>
	</div>
</div>

