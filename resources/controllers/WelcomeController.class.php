<?php
require_once(dirname(__FILE__) . "/../config.php");

class WelcomeController extends AbstractController {
	private static $CTR = "welcome";
	
	public static function index() {
		T::render(self::$CTR."/index.php", self::$CTR."/nav.php", array());
	}
}
?>