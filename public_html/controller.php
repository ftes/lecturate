<?php
require_once(dirname(__FILE__) . "/../resources/config.php");

function get(array $array, $key, $default) {
	if (array_key_exists($key, $array)) return $array[$key];
	return $default;
}

$controller = Util::camelCase(get($_GET, "controller", "student"));
$action = strtolower(get($_GET, "action", "index"));

if (! isset($_SESSION["history"])) $_SESSION["history"] = array();
array_push($_SESSION["history"], T::href($controller, $action));

call_user_func_array($controller . "Controller::" . $action, array());
?>