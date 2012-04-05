<?php
abstract class AbstractController {
	public static function get(array $array, $key) {
		if (array_key_exists($key, $array)) return $array[$key];
		return false;
	}
}
?>