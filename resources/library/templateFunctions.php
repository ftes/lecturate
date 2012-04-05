<?php  
require_once(realpath(dirname(__FILE__) . "/../config.php"));

abstract class TemplateConst {
	const SUBMIT = "submit";
	const QUIT = "quit";
}

function renderLayoutWithContentFile($contentFile, $columnRightFile, $variables = array())
{
	$contentFileFullPath = VIEWS_PATH . "/" . $contentFile;
	$columnRightFileFullPath = VIEWS_PATH . "/" . $columnRightFile;

	// making sure passed in variables are in scope of the template
	// each key in the $variables array will become a variable
	if (count($variables) > 0) {
		foreach ($variables as $key => $value) {
			if (strlen($key) > 0) {
				${
					$key} = $value;
			}
		}
	}



	echo "<div id=\"container\">\n";

	require_once(TEMPLATES_PATH . "/header.php");

	echo "<div id=main>";

	echo "<div id=\"flash\">";
	if (isset($flash)) echo $flash;
	echo "</div>";

	echo "<div id=\"column_left\">\n";

	if (file_exists($contentFileFullPath)) {
		require_once($contentFileFullPath);
	} else {
		/*
		 If the file isn't found the error can be handled in lots of ways.
		In this case we will just include an error template.
		*/
		require_once(TEMPLATES_PATH . "/error.php");
	}

	// close content div
	echo "\t</div>\n\n<div id=\"column_right\">";

	if (file_exists($columnRightFileFullPath)) {
		require_once($columnRightFileFullPath);
	} else {
		/*
		 If the file isn't found the error can be handled in lots of ways.
		In this case we will just include an error template.
		*/
		require_once(TEMPLATES_PATH . "/error.php");
	}

	echo "</div><div id=\"spacer\"></div></div>";

	require_once(TEMPLATES_PATH . "/footer.php");

	// close container div
	echo "</div>\n";
}


function formElement($name, array $def) {
	require_once(MODELS_PATH . "/Model.class.php");
	switch ($def[Model::TYPE]) {
		case Model::VARCHAR:
			$maxlen = 30;
			if (array_key_exists(Model::MAXLEN, $def)) $maxlen = $def[Model::MAXLEN];
			$readonly = "";
			if (array_key_exists(Model::PK, $def) && $def[Model::PK] == true) $readonly = "readonly";
			echo "<input type='text' name='$name' maxlength='$maxlen' $readonly value='{$def[Model::VALUE]}'>";
			break;
		case Model::INT:
			$readonly = "";
			if (array_key_exists(Model::PK, $def) && $def[Model::PK] == true) $readonly = "readonly";
			echo "<input type='number' name='$name' $readonly value='{$def[Model::VALUE]}'>";
			break;
	}
}

function submitButton() {
	$submit = TemplateConst::SUBMIT;
	echo "<input type='submit' name='$submit' value='Speichern'>";
}

function quitButton() {
	$quit = TemplateConst::QUIT;
	echo "<input type='submit' name='$quit' value='Abbrechen'>";
}
?>