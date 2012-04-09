<?php
require_once(dirname(__FILE__) . "/../config.php");

class ClasssController extends AbstractController {
	
	public static function index(array $_GET, array $_POST, $flash=false) {
		$models = Classs::findAll();
		$advisors = array();
		foreach ($models as $model) {
			$id = $model->getValue("id");;
			$aId = $model->getValue("a_id");
			$advisors[$id] = Advisor::findById($aId)->toString();
		}
		
		$variables = array(
				"models" => $models,
				"advisors" => $advisors,
				"flash" => $flash);
		T::render("classs/index.php", "classs/nav.php", $variables);
	}
	
	public static function view(array $_GET, array $_POST, $flash=false) {
		if ($id = self::get($_GET, "id"))
				if ($model = Classs::findById($id)) {
			$advisor = Advisor::findById($model->getValue("a_id"));
			$variables = array(
					"model" => $model,
					"advisor" => $advisor,
					"flash" => $flash);
			T::render("classs/view.php", "classs/nav.php", $variables);
			die();
		}
	
		$flash = "Classs not found";
		self::index($_GET, $_POST, $flash);
	}
	
	public static function create(array $_GET, array $_POST, $flash=false) {
		$model = new Classs();

		if (get($_POST, T::SAVE, false)) {
			foreach ($_POST["model"] as $key => $value)
				$model->setValue($key, $value);
			
			if ($model->persist()) {
				self::index($_GET, $_POST, "Class \"{$model->toString()}\" was saved");
				die();
			} else {
				$flash = "Classs could not be saved";
				foreach ($model->getErrors() as $name => $error)
					$flash .= "<br> - $name: $error";
			}			
		} elseif (get($_POST, T::CANCEL, false))
			self::index($_GET, $_POST);
		
		$advisors = Advisor::findAll();
		
		$variables = array(
				"advisors" => $advisors,
				"flash" => $flash,
				"model" => $model);
		T::render("classs/create.php", "classs/nav.php", $variables);
	}
	
	public static function edit(array $_GET, array $_POST, $flash=false) {
		$model = false;
		
		if (get($_POST, T::SAVE, false)) {
			$model = Classs::findById($_POST["model"]["id"]);
			
			foreach ($_POST["model"] as $key => $value)
				$model->setValue($key, $value);
			
			if ($model->persist()) {
				self::index($_GET, $_POST, "Class \"{$model->toString()}\" was saved");
				die();
			} else {
				$flash = "Classs could not be saved";
				foreach ($model->getErrors() as $name => $error)
					$flash .= "<br> - $name: $error";
			}			
		} elseif (get($_POST, T::CANCEL, false))
			self::index($_GET, $_POST);
		elseif ($id = get($_GET, "id", false))
			$model = Classs::findById($id);
		
		if (! $model) {
			self::index($_GET, $_POST, "Class could not be found");
			die();
		}
		
		$advisors = Advisor::findAll();
		
		$variables = array(
				"advisors" => $advisors,
				"flash" => $flash,
				"model" => $model);
		T::render("classs/edit.php", "classs/nav.php", $variables);
	}
	
	public static function delete(array $_GET, array $_POST, $flash=false) {
		if ($id = get($_GET, "id", false)) {
			$model = Classs::findById($id);
			if ($model && $model->delete())
				$flash = "Classs {$model->toString()} was deleted";
			else $flash = "Couldn't delete Class";
		}
		
		self::index($_GET, $_POST, $flash);		
	}
}
?>