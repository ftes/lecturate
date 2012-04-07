<?php
require_once(realpath(dirname(__FILE__) . "/../config.php"));

class ClasssDocentLectureController extends AbstractController {
	
	public static function index(array $_GET, array $_POST, $flash=false) {
		$models = ClasssDocentLecture::findAll();
		$classses= array();
		$docentLectures = array();
		foreach ($models as $model) {
			$id = $model->getValue("id");
			$cId = $model->getValue("c_id");
			$dlId = $model->getValue("dl_id");
			$classses[$id] = Classs::findById($cId)->toString();
			$docentLectures[$id] = DocentLecture::findById($dlId)->toString();
		}
		
		$variables = array(
				"models" => $models,
				"classses" => $classses,
				"docentLectures" => $docentLectures,
				"flash" => $flash);
		T::render("classs_docent_lecture/index.php", "classs_docent_lecture/nav.php", $variables);
	}
	
	public static function view(array $_GET, array $_POST, $flash=false) {
		if ($id = self::get($_GET, "id"))
				if ($model = ClasssDocentLecture::findById($id)) {
			$classs = Classs::findById($model->getValue("c_id"));
			$docentLecture = DocentLecture::findById($model->getValue("dl_id"));
			$variables = array(
					"model" => $model,
					"class" => $class,
					"docentLecture" => $docentLecture,
					"flash" => $flash);
			T::render("classs_docent_lecture/view.php", "classs_docent_lecture/nav.php", $variables);
			die();
		}
	
		$flash = "ClassDocentLecture not found";
		self::index($_GET, $_POST, $flash);
	}
	
	public static function create(array $_GET, array $_POST, $flash=false) {
		$model = new ClasssDocentLecture();

		if (get($_POST, T::SAVE, false)) {
			foreach ($_POST["model"] as $key => $value)
				$model->setValue($key, $value);
			
			if ($model->persist()) {
				self::index($_GET, $_POST, "ClassDocentLecture \"{$model->toString()}\" was saved");
				die();
			} else {
				$flash = "ClassDocentLecture could not be saved";
				foreach ($model->getErrors() as $name => $error)
					$flash .= "<br> - $name: $error";
			}			
		} elseif (get($_POST, T::CANCEL, false))
			self::index($_GET, $_POST);
		
		$classses = Classs::findAll();
		$docentLectures = DocentLecture::findAll();
		
		$variables = array(
				"classses" => $classses,
				"docentLectures" => $docentLectures,
				"flash" => $flash,
				"model" => $model);
		T::render("classs_docent_lecture/create.php", "classs_docent_lecture/nav.php", $variables);
	}
	
	public static function edit(array $_GET, array $_POST, $flash=false) {
		$model = false;
		
		if (get($_POST, T::SAVE, false)) {
			$model = ClasssDocentLecture::findById($_POST["model"]["id"]);
			
			foreach ($_POST["model"] as $key => $value)
				$model->setValue($key, $value);
			
			if ($model->persist()) {
				self::index($_GET, $_POST, "ClassDocentLecture \"{$model->toString()}\" was saved");
				die();
			} else {
				$flash = "ClassDocentLecture could not be saved";
				foreach ($model->getErrors() as $name => $error)
					$flash .= "<br> - $name: $error";
			}			
		} elseif (get($_POST, T::CANCEL, false))
			self::index($_GET, $_POST);
		elseif ($id = get($_GET, "id", false))
			$model = ClasssDocentLecture::findById($id);
		
		if (! $model) {
			self::index($_GET, $_POST, "ClasssDocentLecture could not be found");
			die();
		}
		
		$classses = Classs::findAll();
		$docentLectures = DocentLecture::findAll();
		
		$variables = array(
				"classses" => $classses,
				"docentLectures" => $docentLectures,
				"flash" => $flash,
				"model" => $model);
		T::render("classs_docent_lecture/edit.php", "classs_docent_lecture/nav.php", $variables);
	}
	
	public static function delete(array $_GET, array $_POST, $flash=false) {
		if ($id = get($_GET, "id", false)) {
			$model = ClasssDocentLecture::findById($id);
			if ($model && $model->delete())
				$flash = "ClassDocentLecture {$model->toString()} was deleted";
			else $flash = "Couldn't delete ClassDocentLecture";
		}
		
		self::index($_GET, $_POST, $flash);		
	}
}
?>