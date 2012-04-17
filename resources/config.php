<?php
/**
 * Autoload functionality to find the correct file in which *.class.php can be found
 * @param string $class
 */
function __autoload($class) {
	$paths = array(RESOURCES_PATH, CONTROLLERS_PATH, LIBRARY_PATH, PERSISTENCE_PATH, MODELS_PATH);
	foreach ($paths as $path) {
		if (file_exists($path . "/$class.class.php")) {
			require_once($path . "/$class.class.php");
			return;
		}
	}
	
	$class = Util::camelCase($class);
	foreach ($paths as $path) {
		if (file_exists($path . "/$class.class.php")) {
			require_once($path . "/$class.class.php");
			return;
		}
	}
}

/**
 * start a PHP sesion
 */
session_start();


/**
 * global configuration constants
 * @var array
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
						"content" => $_SERVER["DOCUMENT_ROOT"] . "/img",
						"layout" => $_SERVER["DOCUMENT_ROOT"] . "/img"
				)
		)
	);

/**
 * Path constants
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

/**
 * error reporting
 */
ini_set("error_reporting", "true");
error_reporting(E_ALL|E_STRCT);

?>