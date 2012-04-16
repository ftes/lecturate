<?php
require_once(dirname(__FILE__) . "/../resources/config.php");

function get(array $array, $key, $default) {
	if (array_key_exists($key, $array)) return $array[$key];
	return $default;
}

$controller = Util::camelCase(get($_GET, "controller", "admin"));
$action = strtolower(get($_GET, "action", "index"));
call_user_func_array($controller . "Controller::" . $action, array());
?>