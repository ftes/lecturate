<?php  
require_once(realpath(dirname(__FILE__) . "/../config.php"));

/**
 * Template class
 * @author lecturate
 * Functions for rendering and displaying views
 */

class T {
	const CANCEL = "cancel";
	const SUBMIT = "submit";
	
	/*
	 * Icon buttons
	 */
	const VIEW = "view";
	const EDIT = "edit";
	const DELETE = "delete";
	const CREATE= "create";
	const INDEX = "index";
	const RATE = "rate";
	const LOGIN = "login";
	const LOGOUT = "logout";
	const HOME = "home";
	
	/*
	 * Flash message types
	 */
	const FLASH_POS = "positive";
	const FLASH_NEG = "negative";
	
	private static $errorHTML = "";

	private static $editable = true;
	private static $uids = array();

	/*
	 * Renders a content view together with a navigation view (for the right column)
	 * $variables are accessible in the view!
	 */
	public static function render($contentFile, $navFile, $variables = array()) {
		$contentFileFullPath = VIEWS_PATH . "/" . $contentFile;
		$navFileFullPath = VIEWS_PATH . "/" . $navFile;

		if (count($variables) > 0) {
			foreach ($variables as $key => $value) {
				if (strlen($key) > 0) {
					${
						$key} = $value;
				}
			}
		}
		require_once(TEMPLATES_PATH . "/main.php");
		die();
	}

	/**
	 * Should input fields be editable?
	 * @param boolean $bool
	 */
	public static function setEditable($bool) {
		self::$editable = $bool;
	}
	
	/**
	 * Generate a unique id for use in HTML tags
	 */
	public static function uid() {
		$length = 10;
		$characters = "0123456789abcdefghijklmnopqrstuvwxyz";
		$uid = "";
		
		do {
		for ($i=0; $i<$length; $i++)
			$uid .= $characters[mt_rand(0, strlen($characters) - 1)];
		} while (array_key_exists($uid, self::$uids));
		
		return $uid;
	}

	/**
	 * Generate an input element based on a model attribute
	 * Type of input-element is automatically determined
	 * @param Attribute $attribute
	 */
	public static function input(Attribute $attribute){
		$name = "name=\"model[{$attribute->getName()}]\"";
		$nullable = $attribute->getNullable();
		$value = "value=\"{$attribute->getValue()}\"";
		$readonly = self::$editable ? "" : "readonly";
		if ($attribute->getAutoIncrement()) $readonly = "readonly";
		$inputUid = self::uid();
		$id = "id=\"$inputUid\"";
		$errorUid = self::uid();
		$onchange = "onchange=\"var value=getElementById('$inputUid').value;var error = '';";
		$onchangeEnd = "getElementById('$errorUid').innerHTML=error;\"";
				
		$html = "";

		/*
		 * Varchar
		 */
		if ($attribute instanceof Varchar) {
			$min = $attribute->getMinLength();
			$max = $attribute->getMaxLength();
			$maxlength = $max ? "maxlength=\"$max\"" : "";
			
			$onchange .= "";
			if ($min) $onchange .= "if (value.length < $min) error += 'Zu kurz (min. $min)';";
			$onchange .= $onchangeEnd;

			$html = "<input $id type=\"text\" $name $maxlength $readonly $onchange $value>";

		/*
		 * Int
		 */
		} elseif ($attribute instanceof  Int) {
			$valueUid = self::uid();
			
			if($attribute->getMax() == false && $attribute->getMax() == false){
				$min = "min=\"{$attribute->getMin()}\"";
				$max = "max=\"{$attribute->getMax()}\"";
				$html = "<input type=\"number\" $name $min $max $readonly $value />";
			} else {	
				$min = "min=\"{$attribute->getMin()}\"";
				$max = "max=\"{$attribute->getMax()}\"";
				$value = "value=\"{$attribute->getMin()}\"";
				$html = "<span class=\"range\"  style=\"background-color: #00CD00;\">";
				$html .= "<input $id type=\"range\" $name $min $max $readonly $value step=\"1\"
					onchange=\"
						var value = document.getElementById('$inputUid').value;
						var input = document.getElementById('$valueUid');
						input.innerHTML = value
						var colors = new Array('#00CD00','#7FFF00','#FFD700','#FF6347','#FF3030');
						input.parentNode.style.backgroundColor = colors[parseInt(value)-1];
					\" />";
				$html .= "<span id=\"$valueUid\" >{$attribute->getMin()}</span>";
				$html .= "</span>";
			}
		}
	
		
		self::$errorHTML = "";
		self::$errorHTML .= "<span class=\"error\" id=\"$errorUid\">";
		foreach ($attribute->getErrors() as $error)
			self::$errorHTML .= "$error<br>";
		self::$errorHTML .= "</span>";
		
		$attribute->getErrors();
		
		return $html;
	}
	
	/**
	 * Generate a select dropdown. Used for value lists or Foreign Keys
	 * @param Attribute $attribute
	 * @param array $options options the user can choose from
	 * @param boolean $optionsSimpleArray TRUE: $options contains text, FALSE: $options contains model objects
	 * @param unknown_type $alternativeName use an alternative name (e.g. name="model[alternative]")
	 * @param unknown_type $js array with javascript that should be put into element
	 * @return string
	 */
	public static function select(Attribute $attribute, array $options, $optionsSimpleArray=false, $alternativeName=false, $js=false) {
		$name = $alternativeName ? "name=\"model[$alternativeName]\"" : "name=\"model[{$attribute->getName()}]\"";
		$nullable = $attribute->getNullable();
		$value = "value=\"{$attribute->getValue()}\"";
		$disabled = self::$editable ? "" : "disabled";
		$size ="size=\"1\"";
		$js = $js ? "$js[0]=\"$js[1]\"" : "";
		
		$html = "<select $name $size $disabled $js>";
		$html .= "<option></option>";
		foreach ($options as $key => $option) {
			if ($optionsSimpleArray) {
				$optionValue = $key;
				$selected = ($attribute->getValue() == $key) ? "selected" : "";
				$optionText = $option;
			} else {
				$pk = $option->getPrimaryKey()->getAttributes();
				$optionValue = $pk[0]->getValue();
				$optionText = $option->toString();
			}
			$selected = ($attribute->getValue() == $optionValue) ? "selected" : "";
			$optionValue = "value=\"$optionValue\"";
			$html .= "<option $optionValue $selected>{$optionText}</option>";
		}
		$html .= "</select";
		
		return $html;
	}
	
	/**
	 * generate field for displaying JS-generated and PHP-generated error messages
	 * @return string
	 */
	public static function error() {
		$errorHTML = self::$errorHTML;
		self::$errorHTML = "";
		return $errorHTML;
		
	}

	/**
	 * Generate form button
	 * @param unknown_type $type Cancel or Submit
	 * @param unknown_type $text text to display on button
	 */
	public static function button($type, $text) {
		$typeText = "type=\"submit\"";
		if ($type == T::CANCEL) {
			$href = T::href("navigation", "back");
			$typeText = "type=\"button\" onclick=\"window.location='$href';\"";
		}
		return "<button $typeText name=\"$type\" value=\"$type\" class=\"button text $type\">$text</button>";
	}
	
	/**
	 * generate a hyperlink to a certain action on a controller
	 * @param unknown_type $controller
	 * @param unknown_type $action
	 * @param unknown_type $array addition GET parameters
	 */
	public static function href($controller="welcome", $action="index", $array=array()) {
		$string = "";
		foreach ($array as $key => $value)
			$string .= "&$key=$value";
		
		return "controller.php?controller=$controller&action=$action" . $string;
	}
	
	/**
	 * generate a button with an icon
	 * @param unknown_type $icon icon name (see T::constants), FALSE: no icon
	 * @param unknown_type $text text to display on button
	 * @param unknown_type $controller
	 * @param unknown_type $action
	 * @param unknown_type $array additional GET parameters
	 */
	public static function iconButton($icon, $text, $controller, $action="index", $array=array()) {
		$type = $text == false ? "notext" : "text";
		return "<a href=\"" . self::href($controller, $action, $array) . "\" class=\"button $type $icon\">$text</a>";
	}
}
?>