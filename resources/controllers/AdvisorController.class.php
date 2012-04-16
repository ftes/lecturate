<?php
require_once(dirname(__FILE__) . "/../config.php");

class AdvisorController extends AbstractController {
	private static $CTR = "advisor";
	private static $TXT = "SGL";
	
	
	public static function index(array $tmp1=null, array $tmp2=null) {
		AdvisorController::login(T::href(self::$CTR, __FUNCTION__));
		
		$variables = array(
				"models" => Advisor::findAll()
				);
		T::render(self::$CTR."/index.php", self::$CTR."/nav.php", $variables);
	}
	
	public static function view(array $tmp1=null, array $tmp2=null) {
		AdvisorController::login(T::href(self::$CTR, __FUNCTION__));
		
		if ($id = self::get($_GET, "id"))
				if ($model = Advisor::findById($id)) {
			$variables = array(
					"model" => $model);
			T::render(self::$CTR."/view.php", self::$CTR."/nav.php", $variables);
			die();
		}
	
		$_SESSION["flash"] = array(T::FLASH_NEG, self::$TXT." konnte nicht gefunden werden");
		Util::redirect(T::href(self::$CTR."", "index"));
	}
	
	public static function create(array $tmp1=null, array $tmp2=null) {
		AdvisorController::login(T::href(self::$CTR, __FUNCTION__));
		
		$model = new Advisor();

		if (get($_POST, T::SUBMIT, false)) {
			foreach ($_POST["model"] as $key => $value)
				$model->setValue($key, $value);
			
			if ($model->persist()) {
				$_SESSION["flash"] = array(T::FLASH_POS, self::$TXT." \"{$model->toString()}\" wurde gespeichert");
				Util::redirect(T::href(self::$CTR."", "index"));
			} else {
				$_SESSION["flash"] = array(T::FLASH_NEG, array(T::FLASH_POS, self::$TXT." konnte nicht gespeichert werden"));
				foreach ($model->getErrors() as $name => $error)
					$_SESSION["flash"][1] .= "<br> - $name: $error";
			}			
		} elseif (get($_POST, T::CANCEL, false))
			Util::redirect(T::href(self::$CTR."", "index"));
		
		$variables = array(
				"model" => $model);
		T::render(self::$CTR."/create.php", self::$CTR."/nav.php", $variables);
	}
	
	public static function edit(array $tmp1=null, array $tmp2=null) {
		AdvisorController::login(T::href(self::$CTR, __FUNCTION__));
		
		$model = false;
		
		if (get($_POST, T::SUBMIT, false)) {
			$model = Advisor::findById($_POST["model"]["id"]);
			
			foreach ($_POST["model"] as $key => $value)
				$model->setValue($key, $value);
			
			if ($model->persist()) {
				$_SESSION["flash"] = array(T::FLASH_POS, self::$TXT." \"{$model->toString()}\" wurde gespeichert");
				Util::redirect(T::href(self::$CTR."", "index"));
			} else {
				$_SESSION["flash"] = array(T::FLASH_POS, array(T::FLASH_NEG, self::$TXT." konnte nicht gespeichert werden"));
				foreach ($model->getErrors() as $name => $error)
					$_SESSION["flash"][1] .= "<br> - $name: $error";
			}			
		} elseif (get($_POST, T::CANCEL, false))
			Util::redirect(T::href(self::$CTR."", "index"));
		elseif ($id = get($_GET, "id", false))
			$model = Advisor::findById($id);
		
		if (! $model) {
			$_SESSION["flash"] = array(T::FLASH_NEG, self::$TXT." konnte nicht gefunden werden");
			Util::redirect(T::href(self::$CTR."", "index"));
		}
		$variables = array(
				"model" => $model);
		T::render(self::$CTR."/edit.php", self::$CTR."/nav.php", $variables);
	}
	
	public static function delete(array $tmp1=null, array $tmp2=null) {
		AdvisorController::login(T::href(self::$CTR, __FUNCTION__));
		
		if ($id = get($_GET, "id", false)) {
			$model = Advisor::findById($id);
			if ($model && $model->delete())
				$_SESSION["flash"] = array(T::FLASH_POS, self::$TXT." {$model->toString()} wurde gelöscht");
			else $_SESSION["flash"] = array(T::FLASH_NEG, self::$TXT." konnte nicht gelöscht werden");
		}
		
		Util::redirect(T::href(self::$CTR."", "index"));
	}
	
	public static function login($redirect=false) {
		if ($redirect && self::get($_SESSION, "login", false)) {
			return;
		} elseif (! $redirect && self::get($_SESSION, "login", false)) {
			$_SESSION["flash"] = array(T::FLASH_NEG, "Bereits angemeldet");
			Util::redirect(T::href(self::$CTR."", "index"));
		}
		
		if ($redirect) $_SESSION["redirect"] = $redirect;
		
		if ($redirect) {
			$_SESSION["flash"] = array(T::FLASH_NEG, "Anmeldung erforderlich");
		}
		
		$model = new Advisor();

		if (get($_POST, T::SUBMIT, false)) {
			foreach ($_POST["model"] as $key => $value)
				$model->setValue($key, $value);
			
			if ($advisor = Advisor::findByUsernamePassword($model->getValue("username"), $model->getValue("password"))) {
				$_SESSION["flash"] = array(T::FLASH_POS, "Anmeldung erfolgreich");
				$_SESSION["login"] = true;
				$_SESSION["advisor"] = $advisor->getValue("id");
				if (get($_SESSION, "redirect", false)) {
					$redirect = $_SESSION["redirect"];
					unset($_SESSION["redirect"]);
					Util::redirect($redirect);
				}
				Util::redirect(T::href(self::$CTR."", "index"));
			} else {
				$_SESSION["flash"] = array(T::FLASH_NEG, "Anmeldung fehlgeschlagen");
				$model->setValue("password", "");	
			}
		} elseif (get($_POST, T::CANCEL, false))
			Util::redirect(T::href(self::$CTR, "index"));
		
		$variables = array(
				"model" => $model);
		T::render(self::$CTR."/login.php", "notexistent", $variables);
	}
	
	public static function logout(array $tmp1=null, array $tmp2=null) {
		if (self::get($_SESSION, "login", false)) {
			unset($_SESSION["login"]);
			$_SESSION["flash"] = array(T::FLASH_POS, "Abmeldung erfolgreich");
		} else {
			$_SESSION["flash"] = array(T::FLASH_NEG, "Nicht angemeldet");
		}
		Util::redirect(T::href(self::$CTR, "login"));
	}
}
?>