<?php
function __autoload($class) {
	$paths = array(CONTROLLERS_PATH, LIBRARY_PATH, PERSISTENCE_PATH, MODELS_PATH);
	$class = Util::camelCase($class);
	foreach ($paths as $path) {
		if (file_exists($path . "/$class.class.php")) {
			require_once($path . "/$class.class.php");
			break;
		}
	}
}

/*
 The important thing to realize is that the config file should be included in every
page of your project, or at least any page you want access to these settings.
This allows you to confidently use these settings throughout a project because
if something changes such as your database credentials, or a path to a specific resource,
you'll only need to update it here.
*/

$config = array(
		"db" => array(
				"dbname" => "lecturate",
				"username" => "lecturate",
				"password" => "pagnia",
				"host" => "localhost"
		),
		"urls" => array(
				"baseUrl" => "localhost"
		),
		"paths" => array(
				"resources" => dirname(__FILE__),
				"css" => $_SERVER["DOCUMENT_ROOT"] . "/css",
				"images" => array(
						"content" => $_SERVER["DOCUMENT_ROOT"] . "/images/content",
						"layout" => $_SERVER["DOCUMENT_ROOT"] . "/images/layout"
				)
		)
	);

final class Util {
	private function __construct() {}
	
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
	
	public static function getArray(array $array, $function) {
		$arr = array();
		foreach ($array as $element) {
			array_push($arr, call_user_func(array($element, $function)));
		}
		return $arr;
	}
	
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
}

/*
 I will usually place the following in a bootstrap file or some type of environment
setup file (code that is run at the start of every page request), but they work
just as well in your config file if it's in php (some alternatives to php are xml or ini files).
*/

/*
 Creating constants for heavily used paths makes things a lot easier.
ex. require_once(LIBRARY_PATH . "Paginator.php")
*/

defined("RESOURCES_PATH")
or define("RESOURCES_PATH", dirname(__FILE__));

defined("LIBRARY_PATH")
or define("LIBRARY_PATH", dirname(__FILE__) . '/library');

defined("CONTROLLERS_PATH")
or define("CONTROLLERS_PATH", dirname(__FILE__) . '/controllers');

defined("PERSISTENCE_PATH")
or define("PERSISTENCE_PATH", LIBRARY_PATH. '/persistence');

defined("TEMPLATES_PATH")
or define("TEMPLATES_PATH", dirname(__FILE__) . '/templates');

defined("VIEWS_PATH")
or define("VIEWS_PATH", dirname(__FILE__) . '/views');

defined("MODELS_PATH")
or define("MODELS_PATH", dirname(__FILE__) . '/models');

defined("SQLLOG")
or define("SQLLOG", RESOURCES_PATH . '/log.txt');

/*
 Error reporting.
*/
ini_set("error_reporting", "true");
error_reporting(E_ALL|E_STRCT);

?>