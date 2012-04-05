<?php
final class Enum {
	private function __construct() {}
	
	public static function enum(array $array, $function, $space=",", $left="", $right="") {
		$string = "";
		foreach ($array as $element) {
			$string .= $left . call_user_func(array($element, $function)) . $right . $space;
		}
		$string = substr($string, 0, strlen($string) - strlen($space));
		return $string;
	}
	
	public static function getArray(array $array, $function) {
		$arr = array();
		foreach ($array as $element) {
			array_push($arr, call_user_func(array($element, $function)));
		}
		return $arr;
	}
}
?>