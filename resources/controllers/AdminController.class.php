<?php
require_once(dirname(__FILE__) . "/../config.php");

/**
 * Admin functionality, e.g. reset the DB
 * @author lecturate
 *
 */
class AdminController extends AbstractController {
	private static $CTR = "admin";
	private static $TXT = "Admin";
	
	public static function index() {
		T::render(self::$CTR."/default.php", self::$CTR."/nav.php", array());
	}
	
	public static function initdb() {
		LoginController::login(T::href(self::$CTR, __FUNCTION__));
		
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
		
		$advisor = new Advisor();
		$advisor->setValue("username", "admin");
		$advisor->setValue("password", "admin");
		$advisor->setValue("firstname", "admin");
		$advisor->setValue("lastname", "admin");
		
		$advisor->persist();
		
		$_SESSION["login"] = false;
		
		$_SESSION["flash"] = array(T::FLASH_POS, "DB wurde initialisiert<br>Standard-SGL admin/admin");
		$variables = array();
		T::render(self::$CTR."/default.php", self::$CTR."/nav.php", $variables);
	}
}