<?php
require_once(realpath(dirname(__FILE__) . "/../config.php"));

class AdvisorController extends AbstractController {
	
	public static function index(array $_GET, array $_POST, $flash=false) {
		$variables = array(
				"models" => Advisor::findAll(),
				"flash" => $flash);
		T::render("advisor/index.php", "advisor/nav.php", $variables);
	}
	
	public static function view(array $_GET, array $_POST, $flash=false) {
		if ($id = self::get($_GET, "id"))
				if ($model = Advisor::findById($id)) {
			$variables = array(
					"model" => $model,
					"flash" => $flash);
			T::render("advisor/view.php", "advisor/nav.php", $variables);
			die();
		}
	
		$flash = "Advisor not found";
		self::index($_GET, $_POST, $flash);
	}
	
	public static function create(array $_GET, array $_POST, $flash=false) {
		$model = new Advisor();

		if (get($_POST, T::SAVE, false)) {
			foreach ($_POST["model"] as $key => $value)
				$model->setValue($key, $value);
			
			if ($model->persist()) {
				self::index($_GET, $_POST, "Advisor \"{$model->toString()}\" was saved");
				die();
			} else {
				$flash = "Advisor could not be saved";
				foreach ($model->getErrors() as $name => $error)
					$flash .= "<br> - $name: $error";
			}			
		} elseif (get($_POST, T::CANCEL, false))
			self::index($_GET, $_POST);
		
		$variables = array(
				"flash" => $flash,
				"model" => $model);
		T::render("advisor/create.php", "advisor/nav.php", $variables);
	}
	
	public static function edit(array $_GET, array $_POST, $flash=false) {
		$model = false;
		
		if (get($_POST, T::SAVE, false)) {
			$model = Advisor::findById($_POST["model"]["id"]);
			
			foreach ($_POST["model"] as $key => $value)
				$model->setValue($key, $value);
			
			if ($model->persist()) {
				self::index($_GET, $_POST, "Advisor \"{$model->toString()}\" was saved");
				die();
			} else {
				$flash = "Advisor could not be saved";
				foreach ($model->getErrors() as $name => $error)
					$flash .= "<br> - $name: $error";
			}			
		} elseif (get($_POST, T::CANCEL, false))
			self::index($_GET, $_POST);
		elseif ($id = get($_GET, "id", false))
			$model = Advisor::findById($id);
		
		if (! $model) {
			self::index($_GET, $_POST, "Advisor could not be found");
			die();
		}
		$variables = array(
				"flash" => $flash,
				"model" => $model);
		T::render("advisor/edit.php", "advisor/nav.php", $variables);
	}
	
	public static function delete(array $_GET, array $_POST, $flash=false) {
		if ($id = get($_GET, "id", false)) {
			$model = Advisor::findById($id);
			if ($model && $model->delete())
				$flash = "Advisor {$model->toString()} was deleted";
			else $flash = "Couldn't delete advisor";
		}
		
		self::index($_GET, $_POST, $flash);		
	}
}
?>