<?php
final class Enum {
	private function __construct() {}
	
	public static function enum(array $array, $function, $space=",") {
		$string = "";
		foreach ($array as $element) {
			$string .= call_user_func(array($element, $function)) . $space;
		}
		$string = substr($string, 0, strlen($string) - strlen($space));
		return $string;
	}
}
?>