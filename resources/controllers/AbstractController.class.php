<?php

/**
 * Abstract controller class
 * Controllers delegate between the data model and views
 * they get data, repackage it into the correct form and run the business logic
 * @author lecturate
 *
 */
abstract class AbstractController {
	public static function get(array $array, $key) {
		if (array_key_exists($key, $array)) return $array[$key];
		return false;
	}
}
?>