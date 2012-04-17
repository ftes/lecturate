<?php
require_once(dirname(__FILE__) . "/../config.php");

/**
 * Simply serves the static welcome page
 * @author lecturate
 *
 */
class WelcomeController extends AbstractController {
	private static $CTR = "welcome";

	public static function index() {
		T::render(self::$CTR."/index.php", self::$CTR."/nav.php", array());
	}
}
?>
