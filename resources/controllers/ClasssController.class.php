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
	
		$flash = array(T::FLASH_POS, array(T::FLASH_NEG, "Kurs konnte nicht gefunden werden"));
		self::index($_GET, $_POST, $flash);
	}
	
	public static function create(array $_GET, array $_POST, $flash=false) {
		$model = new Classs();

		if (get($_POST, T::SUBMIT, false)) {
			foreach ($_POST["model"] as $key => $value)
				$model->setValue($key, $value);
			
			if ($model->persist()) {
				self::index($_GET, $_POST, array(T::FLASH_POS, "Kurs \"{$model->toString()}\" wurde gespeichert"));
				die();
			} else {
				$flash = array(T::FLASH_NEG, "Kurs konnte nicht gespeichert werden");
				foreach ($model->getErrors() as $name => $error)
					$flash[1] .= "<br> - $name: $error";
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
		
		if (get($_POST, T::SUBMIT, false)) {
			$model = Classs::findById($_POST["model"]["id"]);
			
			foreach ($_POST["model"] as $key => $value)
				$model->setValue($key, $value);
			
			if ($model->persist()) {
				self::index($_GET, $_POST, array(T::FLASH_POS, "Kurs \"{$model->toString()}\" wurde gespeichert"));
				die();
			} else {
				$flash = array(T::FLASH_NEG, "Kurs konnte nicht gespeichert werden");
				foreach ($model->getErrors() as $name => $error)
					$flash[1] .= "<br> - $name: $error";
			}			
		} elseif (get($_POST, T::CANCEL, false))
			self::index($_GET, $_POST);
		elseif ($id = get($_GET, "id", false))
			$model = Classs::findById($id);
		
		if (! $model) {
			self::index($_GET, $_POST, array(T::FLASH_NEG, "Kurs konnte nicht gefunden werden"));
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
				$flash = array(T::FLASH_POS, "Kurs {$model->toString()} wurde gelöscht");
			else $flash = array(T::FLASH_NEG, "Kurs konnte nicht gelöscht werden");
		}
		
		self::index($_GET, $_POST, $flash);		
	}
}
?>