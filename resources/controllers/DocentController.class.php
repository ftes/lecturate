<?php
require_once(dirname(__FILE__) . "/../config.php");

class DocentController extends AbstractController {
	
	public static function index(array $_GET, array $_POST, $flash=false) {
		$variables = array(
				"models" => Docent::findAll(),
				"flash" => $flash);
		T::render("docent/index.php", "docent/nav.php", $variables);
	}
	
	public static function view(array $_GET, array $_POST, $flash=false) {
		if ($id = self::get($_GET, "id"))
				if ($model = Docent::findById($id)) {
			$variables = array(
					"model" => $model,
					"flash" => $flash);
			T::render("docent/view.php", "docent/nav.php", $variables);
			die();
		}
	
		$flash = "Docent not found";
		self::index($_GET, $_POST, $flash);
	}
	
	public static function create(array $_GET, array $_POST, $flash=false) {
		$model = new Docent();

		if (get($_POST, T::SAVE, false)) {
			foreach ($_POST["model"] as $key => $value)
				$model->setValue($key, $value);
			
			if ($model->persist()) {
				self::index($_GET, $_POST, "Docent \"{$model->toString()}\" was saved");
				die();
			} else {
				$flash = "Docent could not be saved";
				foreach ($model->getErrors() as $name => $error)
					$flash .= "<br> - $name: $error";
			}			
		} elseif (get($_POST, T::CANCEL, false))
			self::index($_GET, $_POST);
		
		$variables = array(
				"flash" => $flash,
				"model" => $model);
		T::render("docent/create.php", "docent/nav.php", $variables);
	}
	
	public static function edit(array $_GET, array $_POST, $flash=false) {
		$model = false;
		
		if (get($_POST, T::SAVE, false)) {
			$model = Docent::findById($_POST["model"]["id"]);
			
			foreach ($_POST["model"] as $key => $value)
				$model->setValue($key, $value);
			
			if ($model->persist()) {
				self::index($_GET, $_POST, "Docent \"{$model->toString()}\" was saved");
				die();
			} else {
				$flash = "Docent could not be saved";
				foreach ($model->getErrors() as $name => $error)
					$flash .= "<br> - $name: $error";
			}			
		} elseif (get($_POST, T::CANCEL, false))
			self::index($_GET, $_POST);
		elseif ($id = get($_GET, "id", false))
			$model = Docent::findById($id);
		
		if (! $model) {
			self::index($_GET, $_POST, "Docent could not be found");
			die();
		}
		$variables = array(
				"flash" => $flash,
				"model" => $model);
		T::render("docent/edit.php", "docent/nav.php", $variables);
	}
	
	public static function delete(array $_GET, array $_POST, $flash=false) {
		if ($id = get($_GET, "id", false)) {
			$model = Docent::findById($id);
			if ($model && $model->delete())
				$flash = "Docent {$model->toString()} was deleted";
			else $flash = "Couldn't delete docent";
		}
		
		self::index($_GET, $_POST, $flash);		
	}
}
?>