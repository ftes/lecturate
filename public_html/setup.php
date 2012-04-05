<?php
require_once(realpath(dirname(__FILE__) . "/../resources/config.php"));

function __autoload($class) {
// 	echo $class . ", ";
	$path = realpath(dirname(__FILE__) . "/../resources/generic/" . $class . ".class.php");
	require_once($path);
}

$mod = new Module();
echo $mod->getSql();

$mod->setValue("name", "ab");
$errors = $mod->persist();
?>