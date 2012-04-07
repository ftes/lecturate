<?php
require_once(realpath(dirname(__FILE__) . "/../config.php"));

class LectureController extends AbstractController {
	
	public static function index(array $_GET, array $_POST, $flash=false) {
		$variables = array(
				"models" => Lecture::findAll(),
				"flash" => $flash);
		T::render("lecture/index.php", "lecture/nav.php", $variables);
	}
	
	public static function view(array $_GET, array $_POST, $flash=false) {
		if ($id = self::get($_GET, "id"))
				if ($model = Lecture::findById($id)) {
			$variables = array(
					"model" => $model,
					"flash" => $flash);
			T::render("lecture/view.php", "lecture/nav.php", $variables);
			die();
		}
	
		$flash = "Lecture not found";
		self::index($_GET, $_POST, $flash);
	}
	
	public static function create(array $_GET, array $_POST, $flash=false) {
		$model = new Lecture();

		if (get($_POST, T::SAVE, false)) {
			foreach ($_POST["model"] as $key => $value)
				$model->setValue($key, $value);
			
			if ($model->persist()) {
				self::index($_GET, $_POST, "Lecture \"".$model->getValue("token")."\" was saved");
				die();
			} else {
				$flash = "Lecture could not be saved";
				foreach ($model->getErrors() as $name => $error)
					$flash .= "<br> - $name: $error";
			}			
		} elseif (get($_POST, T::CANCEL, false))
			self::index($_GET, $_POST);
		
		$variables = array(
				"flash" => $flash,
				"model" => $model);
		T::render("lecture/create.php", "lecture/nav.php", $variables);
	}
	
	public static function edit(array $_GET, array $_POST, $flash=false) {
		$model = false;
		
		if (get($_POST, T::SAVE, false)) {
			$model = Lecture::findById($_POST["model"]["id"]);
			
			foreach ($_POST["model"] as $key => $value)
				$model->setValue($key, $value);
			
			if ($model->persist()) {
				self::index($_GET, $_POST, "Lecture \"".$model->getValue("token")."\" was saved");
				die();
			} else {
				$flash = "Lecture could not be saved";
				foreach ($model->getErrors() as $name => $error)
					$flash .= "<br> - $name: $error";
			}			
		} elseif (get($_POST, T::CANCEL, false))
			self::index($_GET, $_POST);
		elseif ($id = get($_GET, "id", false))
			$model = Lecture::findById($id);
		
		if (! $model) {
			self::index($_GET, $_POST, "Lecture could not be found");
			die();
		}
		$variables = array(
				"flash" => $flash,
				"model" => $model);
		T::render("lecture/edit.php", "lecture/nav.php", $variables);
	}
	
	public static function delete(array $_GET, array $_POST, $flash=false) {
		if ($id = get($_GET, "id", false)) {
			$model = Lecture::findById($id);
			if ($model && $model->delete())
				$flash = "Lecture {$model->getValue("token")} was deleted";
			else $flash = "Couldn't delete lecture";
		}
		
		self::index($_GET, $_POST, $flash);		
	}
}
?>