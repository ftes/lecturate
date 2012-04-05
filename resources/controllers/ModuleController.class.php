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
		if (get($_POST, T::SUBMIT)) {
			//try to save and deal with it not working (pass error messages on)
			die();
		}
		
		$variables = array(
				"flash" => $flash);
		T::render("module/create.php", "module/nav.php", $variables);
		
	}
	
	public static function edit(array $_GET, array $_POST, $flash=false) {
		echo "Hier";
	}
	
	public static function delete(array $_GET, array $_POST, $flash=false) {
		echo "Hier";
	}
}

// switch ($queryString[0]) {
// 	case "view":
// 		if ($modul) {
// 			$variables["modul"] = $modul;
// 			renderLayoutWithContentFile("modul/view.php", "modul/nav.php", $variables);
// 			die();
// 		}
// 		$variables["flash"] = "Modul konnte nicht gefunden werden";
// 		break;
		
// 	case "create":
// 		$modul = new Modul();
// 		if (array_key_exists(TemplateConst::QUIT, $_POST)) break;
// 		if (array_key_exists(TemplateConst::SUBMIT, $_POST)) {
// 			if ($modul->setName($_POST["name"]) && $modul->persist())
// 				$variables["flash"] = "Modul {$modul->getId()} wurde gespeichert.";
// 			else 
// 				$variables["flash"] = "Modul konnte nicht gespeichert werden.";
// 			break;
// 		}
// 		$variables["modul"] = $modul;
// 		renderLayoutWithContentFile("modul/create.php", "modul/nav.php", $variables);
// 		die();
		
// 	case "edit":
// 		if (array_key_exists(TemplateConst::QUIT, $_POST)) break;
// 		if (array_key_exists(TemplateConst::SUBMIT, $_POST)) {
// 			$modul = Modul::read($_POST["id"]);			
// 			if ($modul && $modul->setName($_POST["name"]) && $modul->persist())
// 				$variables["flash"] = "Aenderungen an Modul {$modul->getId()} wurden gespeichert.";
// 			else 
// 				$variables["flash"] = "Aenderungen konnten nicht gespeichert werden.";
// 			break;
// 		}
// 		if ($modul) {
// 			$variables["modul"] = $modul;
// 			renderLayoutWithContentFile("modul/edit.php", "modul/nav.php", $variables);
// 			die();
// 		}
// 		$variables["flash"] = "Modul konnte nicht gefunden werden";
// 		break;
		
// 	case "delete":
// 		if (Modul::delete($id)) $flash = "Modul $id wurde geloescht";
// 		else $flash = "Modul $id konnte nicht geloescht werden";
// 		$variables["flash"] = $flash;
// 		break;
// }

// //CASE "list":
// //here, so in failure cases others can resort to it as well
// $module = Modul::getAll();
// $variables['module'] = $module;
// renderLayoutWithContentFile("modul/list.php", "modul/nav.php", $variables);
//

?>