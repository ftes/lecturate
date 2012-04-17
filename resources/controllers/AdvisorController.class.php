<?php
require_once(dirname(__FILE__) . "/../config.php");

class AdvisorController extends AbstractController {
	private static $CTR = "advisor";
	private static $TXT = "SGL";
	
	
	public static function index() {
		LoginController::login(T::href(self::$CTR, __FUNCTION__));
		
		$variables = array(
				"models" => Advisor::findAll()
				);
		T::render(self::$CTR."/index.php", self::$CTR."/nav.php", $variables);
	}
	
	public static function view() {
		LoginController::login(T::href(self::$CTR, __FUNCTION__));
		
		if ($id = self::get($_GET, "id"))
				if ($model = Advisor::findById($id)) {
			$variables = array(
					"model" => $model);
			T::render(self::$CTR."/view.php", self::$CTR."/nav.php", 
					$variables);
			die();
		}
	
		$_SESSION["flash"] = array(T::FLASH_NEG, 
				self::$TXT." konnte nicht gefunden werden");
		Util::redirect(T::href(self::$CTR."", "index"));
	}
	
	public static function create() {
		LoginController::login(T::href(self::$CTR, __FUNCTION__));
		
		$model = new Advisor();

		if (get($_POST, T::SUBMIT, false)) {
			foreach ($_POST["model"] as $key => $value)
				$model->setValue($key, $value);
			
			if ($model->persist()) {
				$_SESSION["flash"] = array(T::FLASH_POS, 
						self::$TXT." \"{$model->toString()}\" wurde gespeichert");
				Util::redirect(T::href(self::$CTR."", "index"));
			} else {
				$_SESSION["flash"] = array(T::FLASH_NEG, array(T::FLASH_POS, 
						self::$TXT." konnte nicht gespeichert werden"));
				foreach ($model->getErrors() as $name => $error)
					$_SESSION["flash"][1] .= "<br> - $name: $error";
			}			
		} elseif (get($_POST, T::CANCEL, false))
			Util::redirect(T::href(self::$CTR."", "index"));
		
		$variables = array(
				"model" => $model);
		T::render(self::$CTR."/create.php", self::$CTR."/nav.php", $variables);
	}
	
	public static function edit() {
		LoginController::login(T::href(self::$CTR, __FUNCTION__));
		
		$model = false;
		
		if (get($_POST, T::SUBMIT, false)) {
			$model = Advisor::findById($_POST["model"]["id"]);
			
			foreach ($_POST["model"] as $key => $value)
				$model->setValue($key, $value);
			
			if ($model->persist()) {
				$_SESSION["flash"] = array(T::FLASH_POS, 
						self::$TXT." \"{$model->toString()}\" wurde gespeichert");
				Util::redirect(T::href(self::$CTR."", "index"));
			} else {
				$_SESSION["flash"] = array(T::FLASH_POS, array(T::FLASH_NEG, 
						self::$TXT." konnte nicht gespeichert werden"));
				foreach ($model->getErrors() as $name => $error)
					$_SESSION["flash"][1] .= "<br> - $name: $error";
			}			
		} elseif (get($_POST, T::CANCEL, false))
			Util::redirect(T::href(self::$CTR."", "index"));
		elseif ($id = get($_GET, "id", false))
			$model = Advisor::findById($id);
		
		if (! $model) {
			$_SESSION["flash"] = array(T::FLASH_NEG, 
					self::$TXT." konnte nicht gefunden werden");
			Util::redirect(T::href(self::$CTR."", "index"));
		}
		$variables = array(
				"model" => $model);
		T::render(self::$CTR."/edit.php", self::$CTR."/nav.php", $variables);
	}
	
	public static function delete() {
		LoginController::login(T::href(self::$CTR, __FUNCTION__));
		
		if ($id = get($_GET, "id", false)) {
			$model = Advisor::findById($id);
			if ($model && $model->delete())
				$_SESSION["flash"] = array(T::FLASH_POS, 
						self::$TXT." {$model->toString()} wurde gelöscht");
			else $_SESSION["flash"] = array(T::FLASH_NEG, 
					self::$TXT." konnte nicht gelöscht werden");
		}
		
		Util::redirect(T::href(self::$CTR."", "index"));
	}
}
?>