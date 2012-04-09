<?php
require_once(dirname(__FILE__) . "/../config.php");

class AdminController extends AbstractController {
	public static function index($_GET, $_POST, $flash=false) {
		T::render("admin/default.php", "admin/nav.php", array());
	}
	
	public static function initdb($_GET, $_POST, $flash=false) {
		global $config;
		
		$dbConn = Sql::getDbConn();
		
		$sql = "DROP DATABASE " . $config["db"]["dbname"];
		$dbConn->query($sql);
		Sql::log($sql);
		
		$sql = "CREATE DATABASE " . $config["db"]["dbname"];
		$dbConn->query($sql);
		Sql::log($sql);
		
		$dbConn->select_db($config["db"]["dbname"]);
		
		$models = array(new Lecture(), new Docent(), new DocentLecture(), new Advisor(), new Classs(), new ClasssDocentLecture(), new Otpw(), new Rating());
		foreach ($models as $model) {
			$name = $model->getName();			
			$sql = $model->getSql();
			$dbConn->query($sql);
			Sql::log($sql);
		}
		
		$dbConn->close();
		
		$variables = array(
				"flash" => "Database initialized");
		T::render("admin/default.php", "admin/nav.php", $variables);
	}
}