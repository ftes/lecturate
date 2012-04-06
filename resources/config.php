<?php
function __autoload($class) {
	$paths = array(CONTROLLERS_PATH, LIBRARY_PATH, PERSISTENCE_PATH, MODELS_PATH);
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
				"resources" => realpath(dirname(__FILE__)),
				"css" => $_SERVER["DOCUMENT_ROOT"] . "/css",
				"images" => array(
						"content" => $_SERVER["DOCUMENT_ROOT"] . "/images/content",
						"layout" => $_SERVER["DOCUMENT_ROOT"] . "/images/layout"
				)
		)
	);

function getDbConn() {
	global $config;
	
	$dbConn = new mysqli($config["db"]["host"], $config["db"]["username"], $config["db"]["password"]);

	if (mysqli_connect_errno()) {
		throw new Exception("Connect failed}");
		exit();
	}

	$dbConn->select_db($config["db"]["dbname"]);

	return $dbConn;
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
or define("RESOURCES_PATH", realpath(dirname(__FILE__)));

defined("LIBRARY_PATH")
or define("LIBRARY_PATH", realpath(dirname(__FILE__) . '/library'));

defined("CONTROLLERS_PATH")
or define("CONTROLLERS_PATH", realpath(dirname(__FILE__) . '/controllers'));

defined("PERSISTENCE_PATH")
or define("PERSISTENCE_PATH", LIBRARY_PATH. '/persistence');

defined("TEMPLATES_PATH")
or define("TEMPLATES_PATH", realpath(dirname(__FILE__) . '/templates'));

defined("VIEWS_PATH")
or define("VIEWS_PATH", realpath(dirname(__FILE__) . '/views'));

defined("MODELS_PATH")
or define("MODELS_PATH", realpath(dirname(__FILE__) . '/models'));

defined("SQLLOG")
or define("SQLLOG", RESOURCES_PATH . '/log.txt');

/*
 Error reporting.
*/
ini_set("error_reporting", "true");
error_reporting(E_ALL|E_STRCT);

?>