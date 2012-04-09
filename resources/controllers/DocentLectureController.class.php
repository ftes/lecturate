<?php
require_once(dirname(__FILE__) . "/../config.php");

class DocentLectureController extends AbstractController {
	
	public static function index(array $_GET, array $_POST, $flash=false) {
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
				"lectures" => $lectures,
				"flash" => $flash);
		T::render("docent_lecture/index.php", "docent_lecture/nav.php", $variables);
	}
	
	public static function view(array $_GET, array $_POST, $flash=false) {
		if ($id = self::get($_GET, "id"))
				if ($model = DocentLecture::findById($id)) {
			$docent = Docent::findById($model->getValue("d_id"));
			$lecture = Lecture::findById($model->getValue("l_id"));
			$variables = array(
					"model" => $model,
					"docent" => $docent,
					"lecture" => $lecture,
					"flash" => $flash);
			T::render("docent_lecture/view.php", "docent_lecture/nav.php", $variables);
			die();
		}
	
		$flash = "Dozent hält Vorlesung konnte nicht gefunden werden";
		self::index($_GET, $_POST, $flash);
	}
	
	public static function create(array $_GET, array $_POST, $flash=false) {
		$model = new DocentLecture();

		if (get($_POST, T::SUBMIT, false)) {
			foreach ($_POST["model"] as $key => $value)
				$model->setValue($key, $value);
			
			if ($model->persist()) {
				self::index($_GET, $_POST, "Dozent hält Vorlesung \"{$model->toString()}\" wurde gespeichert");
				die();
			} else {
				$flash = "Dozent hält Vorlesung konnte nicht gespeichert werden";
				foreach ($model->getErrors() as $name => $error)
					$flash .= "<br> - $name: $error";
			}			
		} elseif (get($_POST, T::CANCEL, false))
			self::index($_GET, $_POST);
		
		$docents = Docent::findAll();
		$lectures = Lecture::findAll();
		
		$variables = array(
				"docents" => $docents,
				"lectures" => $lectures,
				"flash" => $flash,
				"model" => $model);
		T::render("docent_lecture/create.php", "docent_lecture/nav.php", $variables);
	}
	
	public static function edit(array $_GET, array $_POST, $flash=false) {
		$model = false;
		
		if (get($_POST, T::SUBMIT, false)) {
			$model = DocentLecture::findById($_POST["model"]["id"]);
			
			foreach ($_POST["model"] as $key => $value)
				$model->setValue($key, $value);
			
			if ($model->persist()) {
				self::index($_GET, $_POST, "Dozent hält Vorlesung \"{$model->toString()}\" wurde gespeichert");
				die();
			} else {
				$flash = "Dozent hält Vorlesung konnte nicht gespeichert werden";
				foreach ($model->getErrors() as $name => $error)
					$flash .= "<br> - $name: $error";
			}			
		} elseif (get($_POST, T::CANCEL, false))
			self::index($_GET, $_POST);
		elseif ($id = get($_GET, "id", false))
			$model = DocentLecture::findById($id);
		
		if (! $model) {
			self::index($_GET, $_POST, "Dozent hält Vorlesung konnte nicht gefunden werden");
			die();
		}
		
		$docents = Docent::findAll();
		$lectures = Lecture::findAll();
		
		$variables = array(
				"docents" => $docents,
				"lectures" => $lectures,
				"flash" => $flash,
				"model" => $model);
		T::render("docent_lecture/edit.php", "docent_lecture/nav.php", $variables);
	}
	
	public static function delete(array $_GET, array $_POST, $flash=false) {
		if ($id = get($_GET, "id", false)) {
			$model = DocentLecture::findById($id);
			if ($model && $model->delete())
				$flash = "Dozent hält Vorlesung {$model->toString()} wurde gelöscht";
			else $flash = "Dozent hält Vorlesung konnte nicht gelöscht werden";
		}
		
		self::index($_GET, $_POST, $flash);		
	}
}
?>