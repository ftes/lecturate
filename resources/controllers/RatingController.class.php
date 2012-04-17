<?php
require_once(dirname(__FILE__) . "/../config.php");

class RatingController extends AbstractController {
	private static $CTR = "rating";
	private static $TXT = "Bewertung";


	public static function index() {
		LoginController::login(T::href(self::$CTR, __FUNCTION__));

		$models = Rating::findAll();
		$otpws = array();
		$docentLectures = array();
		foreach ($models as $model) {
			$id = $model->getValue("id");
			$oId = $model->getValue("o_id");
			$dlId = $model->getValue("dl_id");
			$otpws[$id] = Otpw::findById($oId)->toString();
			$docentLectures[$id] = DocentLecture::findById($dlId)->toString();
		}
		$variables = array(
				"models" => Rating::findAll(),
				"otpws" => $otpws,
				"docentLectures" => $docentLectures);
		T::render(self::$CTR."/index.php", self::$CTR."/nav.php", $variables);
	}

	public static function view() {
		LoginController::login(T::href(self::$CTR, __FUNCTION__));

		if ($id = self::get($_GET, "id"))
			if ($model = Rating::findById($id)) {
			$docentLecture = DocentLecture::findById($model->getValue("dl_id"));
			$otpw = Otpw::findById($model->getValue("o_id"));
			$variables = array(
					"model" => $model,
					"otpw" => $otpw,
					"docentLecture" => $docentLecture,);
			T::render(self::$CTR."/view.php", self::$CTR."/nav.php", $variables);
			die();
		}

		$_SESSION["flash"] = array(T::FLASH_NEG, self::$TXT." konnte nicht gefunden werden");
		Util::redirect(T::href(self::$CTR, "index"));
	}

	public static function create() {
		$model = new Rating();
		$otpw = "";

		if (isset($_SESSION["model"]["otpw"]))
			$otpw = $_SESSION["model"]["otpw"];

		if (isset($_SESSION["model"])) {
			foreach ($_SESSION["model"] as $col => $value)
				$model->setValue($col, $value);
			unset($_SESSION["model"]);
		}

		if (get($_POST, T::SUBMIT, false)) {
			foreach ($_POST["model"] as $key => $value)
				$model->setValue($key, $value);
				
			$otpw = $_POST["model"]["otpw"];
			if ($otpw = Otpw::findByOtpw($otpw))
				$model->setValue("o_id", $otpw->getValue("id"));
				


			$otpw = Otpw::findById($model->getValue("o_id"));
			if ($model->persist()) {
				$otpw->setUsed();
				$otpw->persist();
				$_SESSION["flash"] = array(T::FLASH_POS, self::$TXT." \"{$model->toString()}\" wurde gespeichert");
				Util::redirect(T::href("rating", "create"));
			} else {
				$_SESSION["flash"] = array(T::FLASH_NEG, self::$TXT." konnte nicht gespeichert werden");
				foreach ($model->getErrors() as $name => $error)
					$_SESSION["flash"][1] .= "<br> - $name: $error";
			}
		} elseif (get($_POST, T::CANCEL, false))
		Util::redirect(T::href("student", "index"));

		$docentLectures = DocentLecture::findAll();

		$variables = array(
				"docentLectures" => $docentLectures,
				"model" => $model,
				"otpw" => $otpw);
		T::render(self::$CTR."/create.php", self::$CTR."/nav.php", $variables);
	}

	public static function delete() {
		LoginController::login(T::href(self::$CTR, __FUNCTION__));

		if ($id = get($_GET, "id", false)) {
			$model = Rating::findById($id);
			if ($model && $model->delete())
				$_SESSION["flash"] = array(T::FLASH_POS, self::$TXT." {$model->toString()} wurde gelöscht");
		}

		Util::redirect(T::href(self::$CTR, "index"));
	}
}
?>