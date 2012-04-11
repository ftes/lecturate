<?php
require_once(dirname(__FILE__) . "/../config.php");

class DocentLectureController extends AbstractController {
	
	public static function index(array $_GET, array $_POST) {
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
		T::render("docent_lecture/index.php", "docent_lecture/nav.php", $variables);
	}
	
	public static function view(array $_GET, array $_POST) {
		if ($id = self::get($_GET, "id"))
				if ($model = DocentLecture::findById($id)) {
			$docent = Docent::findById($model->getValue("d_id"));
			$lecture = Lecture::findById($model->getValue("l_id"));
			$variables = array(
					"model" => $model,
					"docent" => $docent,
					"lecture" => $lecture,);
			T::render("docent_lecture/view.php", "docent_lecture/nav.php", $variables);
			die();
		}
	
		$_SESSION["flash"] = array(T::FLASH_NEG, "Dozent hält Vorlesung konnte nicht gefunden werden");
		self::index($_GET, $_POST);
	}
	
	public static function create(array $_GET, array $_POST) {
		$model = new DocentLecture();

		if (get($_POST, T::SUBMIT, false)) {
			foreach ($_POST["model"] as $key => $value)
				$model->setValue($key, $value);
			
			if ($model->persist()) {
				self::index($_GET, $_POST, array(T::FLASH_POS, "Dozent hält Vorlesung \"{$model->toString()}\" wurde gespeichert"));
				die();
			} else {
				$_SESSION["flash"] = array(T::FLASH_NEG, "Dozent hält Vorlesung konnte nicht gespeichert werden");
				foreach ($model->getErrors() as $name => $error)
					$_SESSION["flash"][1] .= "<br> - $name: $error";
			}			
		} elseif (get($_POST, T::CANCEL, false))
			self::index($_GET, $_POST);
		
		$docents = Docent::findAll();
		$lectures = Lecture::findAll();
		
		$variables = array(
				"docents" => $docents,
				"lectures" => $lectures,
				"model" => $model);
		T::render("docent_lecture/create.php", "docent_lecture/nav.php", $variables);
	}
	
	public static function edit(array $_GET, array $_POST) {
		$model = false;
		
		if (get($_POST, T::SUBMIT, false)) {
			$model = DocentLecture::findById($_POST["model"]["id"]);
			
			foreach ($_POST["model"] as $key => $value)
				$model->setValue($key, $value);
			
			if ($model->persist()) {
				self::index($_GET, $_POST, array(T::FLASH_POS, "Dozent hält Vorlesung \"{$model->toString()}\" wurde gespeichert"));
				die();
			} else {
				$_SESSION["flash"] = array(T::FLASH_NEG, "Dozent hält Vorlesung konnte nicht gespeichert werden");
				foreach ($model->getErrors() as $name => $error)
					$_SESSION["flash"][1] .= "<br> - $name: $error";
			}			
		} elseif (get($_POST, T::CANCEL, false))
			self::index($_GET, $_POST);
		elseif ($id = get($_GET, "id", false))
			$model = DocentLecture::findById($id);
		
		if (! $model) {
			self::index($_GET, $_POST, array(T::FLASH_NEG, "Dozent hält Vorlesung konnte nicht gefunden werden"));
			die();
		}
		
		$docents = Docent::findAll();
		$lectures = Lecture::findAll();
		
		$variables = array(
				"docents" => $docents,
				"lectures" => $lectures,
				"model" => $model);
		T::render("docent_lecture/edit.php", "docent_lecture/nav.php", $variables);
	}
	
	public static function delete(array $_GET, array $_POST) {
		if ($id = get($_GET, "id", false)) {
			$model = DocentLecture::findById($id);
			if ($model && $model->delete())
				$_SESSION["flash"] = array(T::FLASH_POS, "Dozent hält Vorlesung {$model->toString()} wurde gelöscht");
			else $_SESSION["flash"] = array(T::FLASH_NEG, "Dozent hält Vorlesung konnte nicht gelöscht werden");
		}
		
		self::index($_GET, $_POST);		
	}
}
?>