<?php
require_once(dirname(__FILE__) . "/../config.php");

class OtpwController extends AbstractController {
	
	public static function index(array $_GET, array $_POST) {
		$models = Otpw::findAll();
		$docentLectures = array();
		foreach ($models as $model) {
			$id = $model->getValue("id");
			$dlId = $model->getValue("dl_id");
			$docentLectures[$id] = DocentLecture::findById($dlId)->toString();
		}
		
		$variables = array(
				"models" => $models,
				"docentLectures" => $docentLectures);
		T::render("otpw/index.php", "otpw/nav.php", $variables);
	}
	
	public static function view(array $_GET, array $_POST) {
		if ($id = self::get($_GET, "id"))
				if ($model = Otpw::findById($id)) {
			$docentLecture = DocentLecture::findById($model->getValue("dl_id"));
			$variables = array(
					"model" => $model,
					"docentLecture" => $docentLecture,
					"usedOptions" => array(0 => "False", 1=> "True"),);
			T::render("otpw/view.php", "otpw/nav.php", $variables);
			die();
		}
	
		$_SESSION["flash"] = array(T::FLASH_NEG, "Einmal-PW konnte nicht gefunden werden");
		self::index($_GET, $_POST);
	}
	
	public static function create(array $_GET, array $_POST) {
		$model = new Otpw();

		if (get($_POST, T::SUBMIT, false)) {
			foreach ($_POST["model"] as $key => $value)
				$model->setValue($key, $value);
			
			if ($model->persist()) {
				self::index($_GET, $_POST, array(T::FLASH_POS, "Einmal-PW \"{$model->toString()}\" wurde gespeichert"));
				die();
			} else {
				$_SESSION["flash"] = array(T::FLASH_NEG, "Einmal-PW konnte nicht gespeichert werden");
				foreach ($model->getErrors() as $name => $error)
					$_SESSION["flash"][1] .= "<br> - $name: $error";
			}			
		} elseif (get($_POST, T::CANCEL, false))
			self::index($_GET, $_POST);
		
		$docentLectures = DocentLecture::findAll();
		
		$variables = array(
				"docentLectures" => $docentLectures,
				"usedOptions" => array(0 => "False", 1=> "True"),
				"model" => $model);
		T::render("otpw/create.php", "otpw/nav.php", $variables);
	}
	
	public static function delete(array $_GET, array $_POST) {
		if ($id = get($_GET, "id", false)) {
			$model = Otpw::findById($id);
			if ($model && $model->delete())
				$_SESSION["flash"] = array(T::FLASH_POS, "Einmal-PW {$model->toString()} wurde gelöscht");
			else $_SESSION["flash"] = array(T::FLASH_NEG, "Einmal-PW konnte nicht gelöscht werden");
		}
		
		self::index($_GET, $_POST);		
	}
}
?>