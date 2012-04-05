<?php
class FormElements {
	const SUBMITTYPE = "submit";
	const QUIT = "quit";
	const SUBMIT = "submit";
	
	private static $editable = true;
	
	public static function setEditable($bool) {
		self::$editable = $bool;
	}
	
	public static function input(Attribute $attribute){
		$name = $attribute->getName();
		$dataType = $attribute->getDataType();
		$nullable = $dataType->getNullable();
		$value = $attribute->getValue();
		$readonly = self::$editable ? "" : "readonly";
		
		if ($dataType instanceof Varchar) {			
			$max = $dataType->getMaxLength() < 0 ? 100 : $dataType->getMaxLength();
			$min = $dataType->getMinLength() < 0 ? 0 : $dataType->getMinLength();
						
			echo "<input type=\"text\" name=\"$name\" maxlength=\"$max\" $readonly value=\"$value\">";
			
		} elseif ($dataType instanceof Int) {
			if ($dataType->getAutoIncrement()) $readonly = "readonly";
			echo "<input type=\"numer\" name=\"$name\" $readonly value=\"$value\">";
		}
	}
	
	public static function button($type, $name, $value) {
		echo "<input type='$type' name='$name' value='$value'>";
	}
}
?>
