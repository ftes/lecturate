<?php
require_once(realpath(dirname(__FILE__) . "/../config.php"));

class ModuleController extends AbstractController {
	
	public static function index(array $_GET, array $_POST, $flash=false) {
		$variables = array(
				"models" => Module::findAll(),
				"flash" => $flash);
		T::render("module/index.php", "module/nav.php", $variables);
	}
	
	public static function view(array $_GET, array $_POST, $flash=false) {
		if ($id = self::get($_GET, "id"))
				if ($model = Module::findById($id)) {
			$variables = array(
					"model" => $model,
					"flash" => $flash);
			T::render("module/view.php", "module/nav.php", $variables);
			die();
		}
	
		$flash = "Module not found";
		self::index($_GET, $_POST, $flash);
	}
	
	public static function create(array $_GET, array $_POST, $flash=false) {
		$model = new Module();

		if (get($_POST, T::SAVE, false)) {
			foreach ($_POST["model"] as $key => $value)
				$model->setValue($key, $value);
			
			if ($model->persist()) {
				self::index($_GET, $_POST, "Module \"{$model->toString()}\" was saved");
				die();
			} else {
				$flash = "Module could not be saved";
				foreach ($model->getErrors() as $name => $error)
					$flash .= "<br> - $name: $error";
			}			
		} elseif (get($_POST, T::CANCEL, false))
			self::index($_GET, $_POST);
		
		$variables = array(
				"flash" => $flash,
				"model" => $model);
		T::render("module/create.php", "module/nav.php", $variables);
	}
	
	public static function edit(array $_GET, array $_POST, $flash=false) {
		$model = false;
		
		if (get($_POST, T::SAVE, false)) {
			$model = Module::findById($_POST["model"]["id"]);
			
			foreach ($_POST["model"] as $key => $value)
				$model->setValue($key, $value);
			
			if ($model->persist()) {
				self::index($_GET, $_POST, "Module \"{$model->toString()}\" was saved");
				die();
			} else {
				$flash = "Module could not be saved";
				foreach ($model->getErrors() as $name => $error)
					$flash .= "<br> - $name: $error";
			}			
		} elseif (get($_POST, T::CANCEL, false))
			self::index($_GET, $_POST);
		elseif ($id = get($_GET, "id", false))
			$model = Module::findById($id);
		
		if (! $model) {
			self::index($_GET, $_POST, "Module could not be found");
			die();
		}
		$variables = array(
				"flash" => $flash,
				"model" => $model);
		T::render("module/edit.php", "module/nav.php", $variables);
	}
	
	public static function delete(array $_GET, array $_POST, $flash=false) {
		if ($id = get($_GET, "id", false)) {
			$model = Module::findById($id);
			if ($model && $model->delete())
				$flash = "Module {$model->toString()} was deleted";
			else $flash = "Couldn't delete module";
		}
		
		self::index($_GET, $_POST, $flash);		
	}
}
?>