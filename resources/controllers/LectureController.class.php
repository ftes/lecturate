<?php
require_once(dirname(__FILE__) . "/../config.php");

class LectureController extends AbstractController {
	
	public static function index(array $_GET, array $_POST) {
		$variables = array(
				"models" => Lecture::findAll());
		T::render("lecture/index.php", "lecture/nav.php", $variables);
	}
	
	public static function view(array $_GET, array $_POST) {
		if ($id = self::get($_GET, "id"))
				if ($model = Lecture::findById($id)) {
			$variables = array(
					"model" => $model,);
			T::render("lecture/view.php", "lecture/nav.php", $variables);
			die();
		}
		
		$_SESSION["flash"] = array(T::FLASH_NEG, array(T::FLASH_NEG, "Vorlesung konnte nicht gefunden werden"));
		self::index($_GET, $_POST);
	}
	
	public static function create(array $_GET, array $_POST) {
		$model = new Lecture();

		if (get($_POST, T::SUBMIT, false)) {
			foreach ($_POST["model"] as $key => $value)
				$model->setValue($key, $value);
			
			if ($model->persist()) {
				self::index($_GET, $_POST, array(T::FLASH_POS, "Vorlesung \"".$model->getValue("token")."\" wurde gespeichert"));
				die();
			} else {
				$_SESSION["flash"] = array(T::FLASH_NEG, "Vorlesung konnte nicht gespeichert werden");
				foreach ($model->getErrors() as $name => $error)
					$_SESSION["flash"][1] .= "<br> - $name: $error";
			}			
		} elseif (get($_POST, T::CANCEL, false))
			self::index($_GET, $_POST);
		
		$variables = array(
				"model" => $model);
		T::render("lecture/create.php", "lecture/nav.php", $variables);
	}
	
	public static function edit(array $_GET, array $_POST) {
		$model = false;
		
		if (get($_POST, T::SUBMIT, false)) {
			$model = Lecture::findById($_POST["model"]["id"]);
			
			foreach ($_POST["model"] as $key => $value)
				$model->setValue($key, $value);
			
			if ($model->persist()) {
				self::index($_GET, $_POST, array(T::FLASH_POS, "Vorlesung \"".$model->getValue("token")."\" wurde gespeichert"));
				die();
			} else {
				$_SESSION["flash"] = array(T::FLASH_NEG, "Vorlesung konnte nicht gespeichert werden");
				foreach ($model->getErrors() as $name => $error)
					$_SESSION["flash"][1] .= "<br> - $name: $error";
			}			
		} elseif (get($_POST, T::CANCEL, false))
			self::index($_GET, $_POST);
		elseif ($id = get($_GET, "id", false))
			$model = Lecture::findById($id);
		
		if (! $model) {
			self::index($_GET, $_POST, array(T::FLASH_NEG, "Vorlesung konnte nicht gefunden werden"));
			die();
		}
		$variables = array(
				"model" => $model);
		T::render("lecture/edit.php", "lecture/nav.php", $variables);
	}
	
	public static function delete(array $_GET, array $_POST) {
		if ($id = get($_GET, "id", false)) {
			$model = Lecture::findById($id);
			if ($model && $model->delete())
				$_SESSION["flash"] = array(T::FLASH_POS, "Vorlesung {$model->getValue("token")} wurde gelöscht");
			else $_SESSION["flash"] = array(T::FLASH_NEG, "Vorlesung konnte nicht gelöscht werden");
		}
		
		self::index($_GET, $_POST);		
	}
}
?>