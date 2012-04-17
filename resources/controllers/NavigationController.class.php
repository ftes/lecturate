<?php
require_once(dirname(__FILE__) . "/../config.php");

class NavigationController extends AbstractController {
	public static function back() {
		//Remove navigation:back and current site
		array_pop($_SESSION["history"]);
		array_pop($_SESSION["history"]);
		
		if (count($_SESSION["history"]) > 0) {
			$last = array_pop($_SESSION["history"]);
			Util::redirect($last);
		}
	}
}