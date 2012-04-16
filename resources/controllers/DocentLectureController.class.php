<?php
require_once(dirname(__FILE__) . "/../config.php");

class DocentLectureController extends AbstractController {
	private static $CTR = "docent_lecture";
	private static $TXT = "Gehaltene Vorlesung";
	
	
	public static function index(array $tmp1=null, array $tmp2=null) {
		AdvisorController::login(T::href(self::$CTR, __FUNCTION__));
		
		$models = DocentLecture::findAll();
		$docents = array();
		$lectures = array();
		foreach ($models as $model) {
			$id = $model->getValue("id");
			$dId = $model->getValue("d_id");
			$lId = $model->getValue("l_id");
			$docents[$id] = Docent::findById($dId)->toString();
			$lectures[$id] = Lecture::findById($lId)->toString();
		}
		
		$variables = array(
				"models" => $models,
				"docents" => $docents,
				"lectures" => $lectures);
		T::render(self::$CTR."/index.php", self::$CTR."/nav.php", $variables);
	}
	
	public static function view(array $tmp1=null, array $tmp2=null) {
		AdvisorController::login(T::href(self::$CTR, __FUNCTION__));
		
		if ($id = self::get($_GET, "id"))
				if ($model = DocentLecture::findById($id)) {
			$docent = Docent::findById($model->getValue("d_id"));
			$lecture = Lecture::findById($model->getValue("l_id"));
			$variables = array(
					"model" => $model,
					"docent" => $docent,
					"lecture" => $lecture,);
			T::render(self::$CTR."/view.php", self::$CTR."/nav.php", $variables);
			die();
		}
	
		$_SESSION["flash"] = array(T::FLASH_NEG, self::$TXT." konnte nicht gefunden werden");
		Util::redirect(T::href(self::$CTR, "index"));
	}
	
	public static function create(array $tmp1=null, array $tmp2=null) {
		AdvisorController::login(T::href(self::$CTR, __FUNCTION__));
		
		$model = new DocentLecture();

		if (get($_POST, T::SUBMIT, false)) {
			foreach ($_POST["model"] as $key => $value)
				$model->setValue($key, $value);
			
			if ($model->persist()) {
				$_SESSION["flash"] = array(T::FLASH_POS, self::$TXT." \"{$model->toString()}\" wurde gespeichert");
				Util::redirect(T::href(self::$CTR, "index"));
			} else {
				$_SESSION["flash"] = array(T::FLASH_NEG, self::$TXT." konnte nicht gespeichert werden");
				foreach ($model->getErrors() as $name => $error)
					$_SESSION["flash"][1] .= "<br> - $name: $error";
			}			
		} elseif (get($_POST, T::CANCEL, false))
			Util::redirect(T::href(self::$CTR, "index"));
		
		$docents = Docent::findAll();
		$lectures = Lecture::findAll();
		
		$variables = array(
				"docents" => $docents,
				"lectures" => $lectures,
				"model" => $model);
		T::render(self::$CTR."/create.php", self::$CTR."/nav.php", $variables);
	}
	
	public static function edit(array $tmp1=null, array $tmp2=null) {
		AdvisorController::login(T::href(self::$CTR, __FUNCTION__));
		
		$model = false;
		
		if (get($_POST, T::SUBMIT, false)) {
			$model = DocentLecture::findById($_POST["model"]["id"]);
			
			foreach ($_POST["model"] as $key => $value)
				$model->setValue($key, $value);
			
			if ($model->persist()) {
				$_SESSION["flash"] = array(T::FLASH_POS, self::$TXT." \"{$model->toString()}\" wurde gespeichert");
				Util::redirect(T::href(self::$CTR, "index"));
			} else {
				$_SESSION["flash"] = array(T::FLASH_NEG, self::$TXT." konnte nicht gespeichert werden");
				foreach ($model->getErrors() as $name => $error)
					$_SESSION["flash"][1] .= "<br> - $name: $error";
			}			
		} elseif (get($_POST, T::CANCEL, false))
			Util::redirect(T::href(self::$CTR, "index"));
		elseif ($id = get($_GET, "id", false))
			$model = DocentLecture::findById($id);
		
		if (! $model) {
			$_SESSION["flash"] = array(T::FLASH_NEG, self::$TXT." konnte nicht gefunden werden");
			Util::redirect(T::href(self::$CTR, "index"));
		}
		
		$docents = Docent::findAll();
		$lectures = Lecture::findAll();
		
		$variables = array(
				"docents" => $docents,
				"lectures" => $lectures,
				"model" => $model);
		T::render(self::$CTR."/edit.php", self::$CTR."/nav.php", $variables);
	}
	
	public static function delete(array $tmp1=null, array $tmp2=null) {
		AdvisorController::login(T::href(self::$CTR, __FUNCTION__));
		
		if ($id = get($_GET, "id", false)) {
			$model = DocentLecture::findById($id);
			if ($model && $model->delete())
				$_SESSION["flash"] = array(T::FLASH_POS, self::$TXT." {$model->toString()} wurde gelöscht");
			else $_SESSION["flash"] = array(T::FLASH_NEG, self::$TXT." konnte nicht gelöscht werden");
		}
		
		Util::redirect(T::href(self::$CTR, "index"));		
	}
}
?>