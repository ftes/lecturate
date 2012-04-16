<?php
require_once(dirname(__FILE__) . "/../config.php");

class LectureController extends AbstractController {
	private static $CTR = "lecture";
	private static $TXT = "Vorlesung";
	
	
	public static function index(array $tmp1=null, array $tmp2=null) {
		AdvisorController::login(T::href(self::$CTR, __FUNCTION__));
		
		$variables = array(
				"models" => Lecture::findAll());
		T::render(self::$CTR."/index.php", self::$CTR."/nav.php", $variables);
	}
	
	public static function view(array $tmp1=null, array $tmp2=null) {
		AdvisorController::login(T::href(self::$CTR, __FUNCTION__));
		
		if ($id = self::get($_GET, "id"))
				if ($model = Lecture::findById($id)) {
			$variables = array(
					"model" => $model,);
			T::render(self::$CTR."/view.php", self::$CTR."/nav.php", $variables);
			die();
		}
		
		$_SESSION["flash"] = array(T::FLASH_NEG, array(T::FLASH_NEG, self::$TXT." konnte nicht gefunden werden"));
		Util::redirect(T::href(self::$CTR, "index"));
	}
	
	public static function create(array $tmp1=null, array $tmp2=null) {
		AdvisorController::login(T::href(self::$CTR, __FUNCTION__));
		
		$model = new Lecture();

		if (get($_POST, T::SUBMIT, false)) {
			foreach ($_POST["model"] as $key => $value)
				$model->setValue($key, $value);
			
			if ($model->persist()) {
				$_SESSION["flash"] = array(T::FLASH_POS, self::$TXT." \"".$model->getValue("token")."\" wurde gespeichert");
				Util::redirect(T::href(self::$CTR, "index"));
			} else {
				$_SESSION["flash"] = array(T::FLASH_NEG, self::$TXT." konnte nicht gespeichert werden");
				foreach ($model->getErrors() as $name => $error)
					$_SESSION["flash"][1] .= "<br> - $name: $error";
			}			
		} elseif (get($_POST, T::CANCEL, false))
			Util::redirect(T::href(self::$CTR, "index"));
		
		$variables = array(
				"model" => $model);
		T::render(self::$CTR."/create.php", self::$CTR."/nav.php", $variables);
	}
	
	public static function edit(array $tmp1=null, array $tmp2=null) {
		AdvisorController::login(T::href(self::$CTR, __FUNCTION__));
		
		$model = false;
		
		if (get($_POST, T::SUBMIT, false)) {
			$model = Lecture::findById($_POST["model"]["id"]);
			
			foreach ($_POST["model"] as $key => $value)
				$model->setValue($key, $value);
			
			if ($model->persist()) {
				$_SESSION["flash"] = array(T::FLASH_POS, self::$TXT." \"".$model->getValue("token")."\" wurde gespeichert");
				Util::redirect(T::href(self::$CTR, "index"));
			} else {
				$_SESSION["flash"] = array(T::FLASH_NEG, self::$TXT." konnte nicht gespeichert werden");
				foreach ($model->getErrors() as $name => $error)
					$_SESSION["flash"][1] .= "<br> - $name: $error";
			}			
		} elseif (get($_POST, T::CANCEL, false))
			Util::redirect(T::href(self::$CTR, "index"));
		elseif ($id = get($_GET, "id", false))
			$model = Lecture::findById($id);
		
		if (! $model) {
			$_SESSION["flash"] = array(T::FLASH_NEG, self::$TXT." konnte nicht gefunden werden");
			Util::redirect(T::href(self::$CTR, "index"));
		}
		$variables = array(
				"model" => $model);
		T::render(self::$CTR."/edit.php", self::$CTR."/nav.php", $variables);
	}
	
	public static function delete(array $tmp1=null, array $tmp2=null) {
		AdvisorController::login(T::href(self::$CTR, __FUNCTION__));
		
		if ($id = get($_GET, "id", false)) {
			$model = Lecture::findById($id);
			if ($model && $model->delete())
				$_SESSION["flash"] = array(T::FLASH_POS, self::$TXT." {$model->getValue("token")} wurde gelöscht");
			else $_SESSION["flash"] = array(T::FLASH_NEG, self::$TXT." konnte nicht gelöscht werden");
		}
		
		Util::redirect(T::href(self::$CTR, "index"));		
	}
}
?>