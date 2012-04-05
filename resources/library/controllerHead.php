<?php
require_once(LIBRARY_PATH . "/templateFunctions.php");

$variables = array();

$id = false;
if (array_key_exists("id", $_GET)) $id = $_GET["id"];

//nur ersten Teil zwischen ? und erstem & betrachten
$queryString = preg_split("/&/", $_SERVER['QUERY_STRING'], -1);



// if (array_key_exists("flash", $_POST)) $variables["flash"] = $_POST["flash"];
?>