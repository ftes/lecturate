<?php  
require_once(realpath(dirname(__FILE__) . "/../config.php"));

class T {
	const CANCEL = "cancel";
	const SAVE = "submit";
	
	private static $errorHTML = "";

	private static $editable = true;
	private static $uids = array();

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
	}

	public static function setEditable($bool) {
		self::$editable = $bool;
	}
	
	private static function uid() {
		$length = 10;
		$characters = "0123456789abcdefghijklmnopqrstuvwxyz";
		$uid = "";
		
		do {
		for ($i=0; $i<$length; $i++)
			$uid .= $characters[mt_rand(0, strlen($characters) - 1)];
		} while (array_key_exists($uid, self::$uids));
		
		return $uid;
	}

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

		if ($attribute instanceof Varchar) {
			$min = $attribute->getMinLength();
			$max = $attribute->getMaxLength();
			$maxlength = $max ? "maxlength=\"$max\"" : "";
			
			$onchange .= "";
			if ($min) $onchange .= "if (value.length < $min) error += 'Too short (min. $min)';";
			$onchange .= $onchangeEnd;

			$html = "<input $id type=\"text\" $name $maxlength $readonly $onchange $value>";

		} elseif ($attribute instanceof Int) {
			$min = "min=\"{$attribute->getMin()}\"";
			$max = "max=\"{$attribute->getMax()}\"";
			$html = "<input $id type=\"number\" $name $min $max $readonly $value\>";
		}
		
		self::$errorHTML = "";
		self::$errorHTML .= "<span class=\"error\" id=\"$errorUid\">";
		foreach ($attribute->getErrors() as $error)
			self::$errorHTML .= "$error<br>";
		self::$errorHTML .= "</span>";
		
		$attribute->getErrors();
		
		return $html;
	}
	
	public static function select(Attribute $attribute, array $options) {
		$name = "name=\"model[{$attribute->getName()}]\"";
		$nullable = $attribute->getNullable();
		$value = "value=\"{$attribute->getValue()}\"";
		$disabled = self::$editable ? "" : "disabled";
		$size = "size=\"{count($options)}\"";
		
		$html = "<select $name $size $disabled>";
		foreach ($options as $option) {
			$pk = $option->getPrimaryKey()->getAttributes();
			$optionValue = "value=\"{$pk[0]->getValue()}\"";
			$selected = ($attribute->getValue() == $pk[0]->getValue()) ? "selected" : "";
			$html .= "<option $optionValue $selected>{$option->toString()}</option>";
		}
		$html .= "</select";
		
		return $html;
	}
	
	public static function error() {
		$errorHTML = self::$errorHTML;
		self::$errorHTML = "";
		return $errorHTML;
		
	}

	public static function button($type) {
		$value = ucfirst($type);
		return "<input type='submit' name='$type' value='$value'>";
	}
	
	public static function href($controller, $action, $array=array()) {
		$string = "";
		foreach ($array as $key => $value)
			$string .= "&$key=$value";
		
		return "controller.php?controller=$controller&action=$action" . $string;
	}
}
?>