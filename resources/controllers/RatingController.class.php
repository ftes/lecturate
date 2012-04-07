<?php
require_once(realpath(dirname(__FILE__) . "/../config.php"));

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

		$flash = "Rating not found";
		self::index($_GET, $_POST, $flash);
	}

	public static function create(array $_GET, array $_POST, $flash=false) {
		$model = new Rating();

		if (get($_POST, T::SAVE, false)) {
			foreach ($_POST["model"] as $key => $value)
				$model->setValue($key, $value);
			
			$otpw = Otpw::findById($model->getValue("o_id"));
			if ($otpw->getValue("dl_id") != $model->getValue("dl_id")) {
				$flash = "OTPW is not meant for this DocentLecture";
			}else {
<<<<<<< HEAD
				if ($model->persist()) {
					$otpw->setUsed();
					$otpw->persist();
=======

				if ($model->persist()) {
>>>>>>> 76d2d51b203a84a61c64ab70c51f0b9542e92454
					self::index($_GET, $_POST, "Rating \"{$model->toString()}\" was saved");
					die();
				} else {
					$flash = "Rating could not be saved";
					foreach ($model->getErrors() as $name => $error)
						$flash .= "<br> - $name: $error";
				}
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

<<<<<<< HEAD
// 	public static function edit(array $_GET, array $_POST, $flash=false) {
// 		$model = false;

// 		if (get($_POST, T::SAVE, false)) {
// 			$model = Rating::findById($_POST["model"]["id"]);

// 			foreach ($_POST["model"] as $key => $value)
// 				$model->setValue($key, $value);

// 			$otpw = Otpw::findById($model->getValue("o_id"));
// 			if ($otpw->getValue("dl_id") != $model->getValue("dl_id")) {
// 				$flash = "OTPW is not meant for this DocentLecture";
// 			} else {
					
// 				if ($model->persist()) {
// 					self::index($_GET, $_POST, "Rating \"{$model->toString()}\" was saved");
// 					die();
// 				} else {
// 					$flash = "Rating could not be saved";
// 					foreach ($model->getErrors() as $name => $error)
// 						$flash .= "<br> - $name: $error";
// 				}
// 			}
// 		} elseif (get($_POST, T::CANCEL, false))
// 		self::index($_GET, $_POST);
// 		elseif ($id = get($_GET, "id", false))
// 		$model = Rating::findById($id);

// 		if (! $model) {
// 			self::index($_GET, $_POST, "Rating could not be found");
// 			die();
// 		}

// 		$otpws = Otpw::findAll();
// 		$docentLectures = DocentLecture::findAll();

// 		$variables = array(
// 				"otpws" => $otpws,
// 				"docentLectures" => $docentLectures,
// 				"flash" => $flash,
// 				"model" => $model);
// 		T::render("rating/edit.php", "rating/nav.php", $variables);
// 	}
=======
	public static function edit(array $_GET, array $_POST, $flash=false) {
		$model = false;

		if (get($_POST, T::SAVE, false)) {
			$model = Rating::findById($_POST["model"]["id"]);

			foreach ($_POST["model"] as $key => $value)
				$model->setValue($key, $value);

			$otpw = Otpw::findById($model->getValue("o_id"));
			if ($otpw->getValue("dl_id") != $model->getValue("dl_id")) {
				$flash = "OTPW is not meant for this DocentLecture";
			} else {
					
				if ($model->persist()) {
					self::index($_GET, $_POST, "Rating \"{$model->toString()}\" was saved");
					die();
				} else {
					$flash = "Rating could not be saved";
					foreach ($model->getErrors() as $name => $error)
						$flash .= "<br> - $name: $error";
				}
			}
		} elseif (get($_POST, T::CANCEL, false))
		self::index($_GET, $_POST);
		elseif ($id = get($_GET, "id", false))
		$model = Rating::findById($id);

		if (! $model) {
			self::index($_GET, $_POST, "Rating could not be found");
			die();
		}

		$otpws = Otpw::findAll();
		$docentLectures = DocentLecture::findAll();

		$variables = array(
				"otpws" => $otpws,
				"docentLectures" => $docentLectures,
				"flash" => $flash,
				"model" => $model);
		T::render("rating/edit.php", "rating/nav.php", $variables);
	}
>>>>>>> 76d2d51b203a84a61c64ab70c51f0b9542e92454

	public static function delete(array $_GET, array $_POST, $flash=false) {
		if ($id = get($_GET, "id", false)) {
			$model = Rating::findById($id);
			if ($model && $model->delete())
				$flash = "Rating {$model->toString()} was deleted";
			else $flash = "Couldn't delete rating";
		}

		self::index($_GET, $_POST, $flash);
	}
}
?>