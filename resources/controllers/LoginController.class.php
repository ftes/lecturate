<?php
require_once(dirname(__FILE__) . "/../config.php");

class LoginController extends AbstractController {
	private static $CTR = "login";
	private static $TXT = "SGL";
	
	public static function login($redirect=false) {
		if ($redirect && self::get($_SESSION, "login", false)) {
			return;
		} elseif (! $redirect && self::get($_SESSION, "login", false)) {
			$_SESSION["flash"] = array(T::FLASH_NEG, "Bereits angemeldet");
			Util::redirect(T::href("advisor", "index"));
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
				Util::redirect(T::href("advisor", "index"));
			} else {
				$_SESSION["flash"] = array(T::FLASH_NEG, "Anmeldung fehlgeschlagen");
				$model->setValue("password", "");	
			}
		} elseif (get($_POST, T::CANCEL, false))
			Util::redirect(T::href("advisor", "index"));
		
		$variables = array(
				"model" => $model);
		T::render(self::$CTR."/login.php", "notexistent", $variables);
	}
	
	public static function logout() {
		if (self::get($_SESSION, "login", false)) {
			unset($_SESSION["login"]);
			$_SESSION["flash"] = array(T::FLASH_POS, "Abmeldung erfolgreich");
		} else {
			$_SESSION["flash"] = array(T::FLASH_NEG, "Nicht angemeldet");
		}
		Util::redirect(T::href("welcome", "index"));
	}
}
?>