<?php
require_once(dirname(__FILE__) . "/../config.php");

class AdvisorController extends AbstractController {
	
	public static function index(array $_GET, array $_POST) {
		$variables = array(
				"models" => Advisor::findAll()
				);
		T::render("advisor/index.php", "advisor/nav.php", $variables);
	}
	
	public static function view(array $_GET, array $_POST) {
		if ($id = self::get($_GET, "id"))
				if ($model = Advisor::findById($id)) {
			$variables = array(
					"model" => $model);
			T::render("advisor/view.php", "advisor/nav.php", $variables);
			die();
		}
	
		$_SESSION["flash"] = array(T::FLASH_NEG, "SGL konnte nicht gefunden werden");
		self::index($_GET, $_POST);
	}
	
	public static function create(array $_GET, array $_POST) {
		$model = new Advisor();

		if (get($_POST, T::SUBMIT, false)) {
			foreach ($_POST["model"] as $key => $value)
				$model->setValue($key, $value);
			
			if ($model->persist()) {
				self::index($_GET, $_POST, array(T::FLASH_POS, "SGL \"{$model->toString()}\" wurde gespeichert"));
				die();
			} else {
				$_SESSION["flash"] = array(T::FLASH_NEG, array(T::FLASH_POS, "SGL konnte nicht gespeichert werden"));
				foreach ($model->getErrors() as $name => $error)
					$_SESSION["flash"][1] .= "<br> - $name: $error";
			}			
		} elseif (get($_POST, T::CANCEL, false))
			self::index($_GET, $_POST);
		
		$variables = array(
				"model" => $model);
		T::render("advisor/create.php", "advisor/nav.php", $variables);
	}
	
	public static function edit(array $_GET, array $_POST) {
		$model = false;
		
		if (get($_POST, T::SUBMIT, false)) {
			$model = Advisor::findById($_POST["model"]["id"]);
			
			foreach ($_POST["model"] as $key => $value)
				$model->setValue($key, $value);
			
			if ($model->persist()) {
				self::index($_GET, $_POST, array(T::FLASH_POS, "SGL \"{$model->toString()}\" wurde gespeichert"));
				die();
			} else {
				$_SESSION["flash"] = array(T::FLASH_POS, array(T::FLASH_NEG, "SGL konnte nicht gespeichert werden"));
				foreach ($model->getErrors() as $name => $error)
					$_SESSION["flash"][1] .= "<br> - $name: $error";
			}			
		} elseif (get($_POST, T::CANCEL, false))
			self::index($_GET, $_POST);
		elseif ($id = get($_GET, "id", false))
			$model = Advisor::findById($id);
		
		if (! $model) {
			self::index($_GET, $_POST, array(T::FLASH_NEG, "SGL konnte nicht gefunden werden"));
			die();
		}
		$variables = array(
				"model" => $model);
		T::render("advisor/edit.php", "advisor/nav.php", $variables);
	}
	
	public static function delete(array $_GET, array $_POST) {
		if ($id = get($_GET, "id", false)) {
			$model = Advisor::findById($id);
			if ($model && $model->delete())
				$_SESSION["flash"] = array(T::FLASH_POS, "SGL {$model->toString()} wurde gelöscht");
			else $_SESSION["flash"] = array(T::FLASH_NEG, "SGL konnte nicht gelöscht werden");
		}
		
		self::index($_GET, $_POST);		
	}
}
?>