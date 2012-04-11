<?php
require_once(dirname(__FILE__) . "/../config.php");

class RatingController extends AbstractController {
	private static $CTR = "rating";
	private static $TXT = "Bewertung";
	

	public static function index(array $_GET, array $_POST) {
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

	public static function view(array $_GET, array $_POST) {
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

	public static function create(array $_GET, array $_POST) {
		$model = new Rating();
		
		if (isset($_SESSION["model"]))
			foreach ($_SESSION["model"] as $col => $value)
				$model->setValue($col, $value);

		if (get($_POST, T::SUBMIT, false)) {
			foreach ($_POST["model"] as $key => $value)
				$model->setValue($key, $value);

			$otpw = Otpw::findById($model->getValue("o_id"));
			if ($model->persist()) {
				$otpw->setUsed();
				$otpw->persist();
				$_SESSION["flash"] = array(T::FLASH_POS, self::$TXT." \"{$model->toString()}\" wurde gespeichert");
				Util::redirect(T::href(self::$CTR, "index"));
			} else {
				$_SESSION["flash"] = array(T::FLASH_NEG, self::$TXT." konnte nicht gespeichert werden");
				foreach ($model->getErrors() as $name => $error)
					$_SESSION["flash"][1] .= "<br> - $name: $error";
			}
		} elseif (get($_POST, T::CANCEL, false))
		Util::redirect(T::href(self::$CTR, "index"));

		$otpws = Otpw::findAll();
		$docentLectures = DocentLecture::findAll();

		$variables = array(
				"otpws" => $otpws,
				"docentLectures" => $docentLectures,
				"model" => $model);
		T::render(self::$CTR."/create.php", self::$CTR."/nav.php", $variables);
	}

	public static function delete(array $_GET, array $_POST) {
		if ($id = get($_GET, "id", false)) {
			$model = Rating::findById($id);
			if ($model && $model->delete())
				$_SESSION["flash"] = array(T::FLASH_POS, self::$TXT." {$model->toString()} wurde gelöscht");
		}

		Util::redirect(T::href(self::$CTR, "index"));
	}
}
?>