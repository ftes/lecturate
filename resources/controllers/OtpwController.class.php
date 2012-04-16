<?php
require_once(dirname(__FILE__) . "/../config.php");

class OtpwController extends AbstractController {
	private static $CTR = "otpw";
	private static $TXT = "Einmal-PW";
	
	
	public static function index(array $tmp1=null, array $tmp2=null) {
		AdvisorController::login(T::href(self::$CTR, __FUNCTION__));
		
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
		T::render(self::$CTR."/index.php", self::$CTR."/nav.php", $variables);
	}
	
	public static function view(array $tmp1=null, array $tmp2=null) {
		AdvisorController::login(T::href(self::$CTR, __FUNCTION__));
		
		if ($id = self::get($_GET, "id"))
				if ($model = Otpw::findById($id)) {
			$docentLecture = DocentLecture::findById($model->getValue("dl_id"));
			$variables = array(
					"model" => $model,
					"docentLecture" => $docentLecture,
					"usedOptions" => array(0 => "False", 1=> "True"),);
			T::render(self::$CTR."/view.php", self::$CTR."/nav.php", $variables);
			die();
		}
	
		$_SESSION["flash"] = array(T::FLASH_NEG, self::$TXT." konnte nicht gefunden werden");
		Util::redirect(T::href(self::$CTR, "index"));
	}
	
	public static function create(array $tmp1=null, array $tmp2=null) {
		AdvisorController::login(T::href(self::$CTR, __FUNCTION__));
		
		$model = new Otpw();

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
		
		$docentLectures = DocentLecture::findAll();
		
		$variables = array(
				"docentLectures" => $docentLectures,
				"usedOptions" => array(0 => "False", 1=> "True"),
				"model" => $model);
		T::render(self::$CTR."/create.php", self::$CTR."/nav.php", $variables);
	}
	
	public static function delete(array $tmp1=null, array $tmp2=null) {
		AdvisorController::login(T::href(self::$CTR, __FUNCTION__));
		
		if ($id = get($_GET, "id", false)) {
			$model = Otpw::findById($id);
			if ($model && $model->delete())
				$_SESSION["flash"] = array(T::FLASH_POS, self::$TXT." {$model->toString()} wurde gelöscht");
			else $_SESSION["flash"] = array(T::FLASH_NEG, self::$TXT." konnte nicht gelöscht werden");
		}
		
		Util::redirect(T::href(self::$CTR, "index"));		
	}
	
	public static function generate(array $tmp1=null, array $tmp2=null) {
		AdvisorController::login(T::href(self::$CTR, __FUNCTION__));
		
		$classs = new Classs();
		$classses = Classs::findAll();
		$classsDocentLecture = new ClasssDocentLecture();
		$classsDocentLectures = array();
		$otpws = array();
		
		if (isset($_POST["model"]["c_id"])) {
			$classs->setValue("id", $_POST["model"]["c_id"]);
			$classsObj = Classs::findById($_POST["model"]["c_id"]);
			
			if ($classsObj) {
				$classs = $classsObj;
				$classsDocentLectures = ClasssDocentLecture::findByClass($_POST["model"]["c_id"]);
			}
			
			if (isset($_POST["model"]["cdl_id"])) {
				$classsDocentLecture->setValue("id", $_POST["model"]["cdl_id"]);
				$cdlObj = ClasssDocentLecture::findById($_POST["model"]["cdl_id"]);
					
				if ($cdlObj) {
					$dlId = $cdlObj->getValue("dl_id");
					
					if (isset($_POST["model"]["size"])) {
						$size = $_POST["model"]["size"];
						
						for ($i=0; $i<$size; $i++) {
							$otpw = new Otpw();
							$otpw->generateOtpw();
							$otpw->setValue("dl_id", $dlId);
							echo ($otpw->persist() == false);
							array_push($otpws, $otpw);
						}
					}
				}
			}
		}
		
		$variables = array(
			"classs" => $classs,
			"classses" => $classses,
			"classsDocentLecture" => $classsDocentLecture,
			"classsDocentLectures" => $classsDocentLectures,
			"otpws" => $otpws
		);
		
		T::render(self::$CTR."/generate.php", self::$CTR."/nav.php", $variables);
	}
}
?>