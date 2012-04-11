<?php
class StudentController extends AbstractController {
	private static $CTR = "student";
	private static $TXT = "Student";
	
	public static function index($_GET, $_POST) {
		$classses = array();
		$classsDocentLectures = array();
		
		$classs = new Classs();
		$classsDocentLecture = new ClasssDocentLecture();
		
		if (isset($_POST["model"]["c_id"])) {
			$classs->setValue("id", $_POST["model"]["c_id"]);
			$classsDocentLectures = ClasssDocentLecture::findByClass($_POST["model"]["c_id"]);
		}
		
		if (isset($_POST["model"]["cdl_id"])) {
			$classsDocentLecture->setValue("id", $_POST["model"]["cdl_id"]);
			$cDLObject = ClasssDocentLecture::findById($_POST["model"]["cdl_id"]);
			if ($cDLObject) {
				$dlId = $cDLObject->getValue("dl_id");
				$docentLecture = DocentLecture::findById($dlId);
				
				$_SESSION["model"]["dl_id"] = $dlId;
				Util::redirect(T::href("rating", "create"));
			}
		}
		
		$classses = Classs::findAll();
		
		
		$variables = array(
			
			"classs" => $classs,
			"classses" => $classses,
			"classsDocentLecture" => $classsDocentLecture,
			"classsDocentLectures" => $classsDocentLectures
		);
		
		T::render("student/index.php", "student/index.php", $variables);
	}
}
?>