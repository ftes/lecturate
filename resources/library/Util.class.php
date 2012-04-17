<?php

/**
 * Utility class for all kinds of functions
 * @author lecturate
 *
 */
final class Util {
	/**
	 * hide constructor
	 */
	private function __construct() {
	}

	/**
	 * Create String out of array of objects
	 * @param array $array array containing objects
	 * @param string $function what function to call on objects to get result string
	 * @param string $space how to seperate object strings
	 * @param string $left what to display to the left of every string
	 * @param string $right what to display to the right of every string
	 * @param boolean $blanks allow blank values?
	 * @return string
	 */
	public static function enum(array $array, $function, $space=",", $left="", $right="", $blanks=true) {
		$string = "";
		foreach ($array as $element) {
			$result = call_user_func(array($element, $function));
			if ($result != "" || $blanks)
				$string .= $left . $result . $right . $space;
		}
		$string = substr($string, 0, strlen($string) - strlen($space));
		return $string;
	}

	/**
	 * similar to enum(), but put result of calling function on objects in an array
	 * @param array $array
	 * @param string $function
	 */
	public static function getArray(array $array, $function) {
		$arr = array();
		foreach ($array as $element) {
			array_push($arr, call_user_func(array($element, $function)));
		}
		return $arr;
	}

	/**
	 * CamelCase a string, using _ to indicate that a uppercase letter comes next
	 * @param unknown_type $string
	 */
	public static function camelCase($string) {
		$string = ucfirst($string);
		while ($pos = strpos($string, "_")) {
			if (substr($string, $pos, 1) == "_") {
				$front = substr($string, 0, $pos);
				$rear = ucfirst(substr($string, $pos+1));
				$string = $front . $rear;
			}
		}
		return $string;
	}

	/**
	 * redirect to another page
	 * @param string $location
	 */
	public static function redirect($location) {
		header("Location: $location");
		die();
	}
}
?>