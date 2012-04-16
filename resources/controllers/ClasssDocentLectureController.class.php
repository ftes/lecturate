<?php
require_once(dirname(__FILE__) . "/../config.php");

class ClasssDocentLectureController extends AbstractController {
	private static $CTR = "classs_docent_lecture";
	private static $TXT = "Kurs hört gehaltene Vorlesung";
	
	
	public static function index(array $tmp1=null, array $tmp2=null) {
		AdvisorController::login(T::href(self::$CTR, __FUNCTION__));
		
		$models = ClasssDocentLecture::findAll();
		$classses= array();
		$docentLectures = array();
		foreach ($models as $model) {
			$id = $model->getValue("id");
			$cId = $model->getValue("c_id");
			$dlId = $model->getValue("dl_id");
			$classses[$id] = Classs::findById($cId)->toString();
			$docentLectures[$id] = DocentLecture::findById($dlId)->toString();
		}
		
		$variables = array(
				"models" => $models,
				"classses" => $classses,
				"docentLectures" => $docentLectures);
		T::render(self::$CTR."/index.php", self::$CTR."/nav.php", $variables);
	}
	
	public static function view(array $tmp1=null, array $tmp2=null) {
		AdvisorController::login(T::href(self::$CTR, __FUNCTION__));
		
		if ($id = self::get($_GET, "id"))
				if ($model = ClasssDocentLecture::findById($id)) {
			$classs = Classs::findById($model->getValue("c_id"));
			$docentLecture = DocentLecture::findById($model->getValue("dl_id"));
			$variables = array(
					"model" => $model,
					"class" => $class,
					"docentLecture" => $docentLecture,);
			T::render(self::$CTR."/view.php", self::$CTR."/nav.php", $variables);
			die();
		}
	
		$_SESSION["flash"] = array(T::FLASH_NEG, self::$TXT." konnte nicht gefunden werden");
		Util::redirect(T::href(self::$CTR, "index"));
	}
	
	public static function create(array $tmp1=null, array $tmp2=null) {
		AdvisorController::login(T::href(self::$CTR, __FUNCTION__));
		
		$model = new ClasssDocentLecture();

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
		
		$classses = Classs::findAll();
		$docentLectures = DocentLecture::findAll();
		
		$variables = array(
				"classses" => $classses,
				"docentLectures" => $docentLectures,
				"model" => $model);
		T::render(self::$CTR."/create.php", self::$CTR."/nav.php", $variables);
	}
	
	public static function edit(array $tmp1=null, array $tmp2=null) {
		AdvisorController::login(T::href(self::$CTR, __FUNCTION__));
		
		$model = false;
		
		if (get($_POST, T::SUBMIT, false)) {
			$model = ClasssDocentLecture::findById($_POST["model"]["id"]);
			
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
			$model = ClasssDocentLecture::findById($id);
		
		if (! $model) {
			$_SESSION["flash"] = array(T::FLASH_NEG, self::$TXT." konnte nicht gefunden werden");
			Util::redirect(T::href(self::$CTR, "index"));
		}
		
		$classses = Classs::findAll();
		$docentLectures = DocentLecture::findAll();
		
		$variables = array(
				"classses" => $classses,
				"docentLectures" => $docentLectures,
				"model" => $model);
		T::render(self::$CTR."/edit.php", self::$CTR."/nav.php", $variables);
	}
	
	public static function delete(array $tmp1=null, array $tmp2=null) {
		AdvisorController::login(T::href(self::$CTR, __FUNCTION__));
		
		if ($id = get($_GET, "id", false)) {
			$model = ClasssDocentLecture::findById($id);
			if ($model && $model->delete())
				$_SESSION["flash"] = array(T::FLASH_POS, self::$TXT." {$model->toString()} wurde gelöscht");
			else $_SESSION["flash"] = array(T::FLASH_NEG, self::$TXT." konnte nicht gelöscht werden");
		}
		
		Util::redirect(T::href(self::$CTR, "index"));	
	}
}
?>