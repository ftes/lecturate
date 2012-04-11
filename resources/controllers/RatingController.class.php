<?php
require_once(dirname(__FILE__) . "/../config.php");

class RatingController extends AbstractController {

	public static function index(array $_GET, array $_POST, $flash=false) {
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
				"docentLectures" => $docentLectures,
				"flash" => $flash);
		T::render("rating/index.php", "rating/nav.php", $variables);
	}

	public static function view(array $_GET, array $_POST, $flash=false) {
		if ($id = self::get($_GET, "id"))
			if ($model = Rating::findById($id)) {
			$docentLecture = DocentLecture::findById($model->getValue("dl_id"));
			$otpw = Otpw::findById($model->getValue("o_id"));
			$variables = array(
					"model" => $model,
					"otpw" => $otpw,
					"docentLecture" => $docentLecture,
					"flash" => $flash);
			T::render("rating/view.php", "rating/nav.php", $variables);
			die();
		}

		$flash = array(T::FLASH_NEG, "Bewertung konnte nicht gefunden werden");
		self::index($_GET, $_POST, $flash);
	}

	public static function create(array $_GET, array $_POST, $flash=false) {
		$model = new Rating();

		if (get($_POST, T::SUBMIT, false)) {
			foreach ($_POST["model"] as $key => $value)
				$model->setValue($key, $value);

			$otpw = Otpw::findById($model->getValue("o_id"));
			if ($model->persist()) {
				$otpw->setUsed();
				$otpw->persist();
				self::index($_GET, $_POST, array(T::FLASH_POS, "Bewertung \"{$model->toString()}\" wurde gespeichert"));
				die();
			} else {
				$flash = array(T::FLASH_NEG, "Bewertung konnte nicht gespeichert werden");
				foreach ($model->getErrors() as $name => $error)
					$flash[1] .= "<br> - $name: $error";
			}
		} elseif (get($_POST, T::CANCEL, false))
		self::index($_GET, $_POST);

		$otpws = Otpw::findAll();
		$docentLectures = DocentLecture::findAll();

		$variables = array(
				"otpws" => $otpws,
				"docentLectures" => $docentLectures,
				"flash" => $flash,
				"model" => $model);
		T::render("rating/create.php", "rating/nav.php", $variables);
	}

	public static function delete(array $_GET, array $_POST, $flash=false) {
		if ($id = get($_GET, "id", false)) {
			$model = Rating::findById($id);
			if ($model && $model->delete())
				$flash = array(T::FLASH_POS, "Bewertung {$model->toString()} wurde gelöscht");
		}

		self::index($_GET, $_POST, $flash);
	}
}
?>