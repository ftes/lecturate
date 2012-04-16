<?php
class StudentController extends AbstractController {
	private static $CTR = "student";
	private static $TXT = "Student";

	public static function index() {
		$classses = Classs::findAll();
		$classsDocentLectures = array();

		$classs = new Classs();
		$classsDocentLecture = new ClasssDocentLecture();

		if (get($_POST, "submit", false)) {
			if (isset($_POST["model"]["otpw"])) {
				$otpw = $_POST["model"]["otpw"];
				if ($otpw = Otpw::findByOtpw($otpw)) {
					if ($otpw->getValue("used") == Bool::F) {
						$_SESSION["model"]["dl_id"] = $otpw->getValue("dl_id");
						$_SESSION["model"]["otpw"] = $otpw->getValue("otpw");
						Util::redirect(T::href("rating", "create"));
					} else {
						$_SESSION["flash"] = array(T::FLASH_NEG, "Einmal-PW wurde schon verwendet");
					}
				} else {
					$_SESSION["flash"] = array(T::FLASH_NEG, "Einmal-PW nicht gefunden");
				}
			} else {

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
			}
		}

		$variables = array(
				"classs" => $classs,
				"classses" => $classses,
				"classsDocentLecture" => $classsDocentLecture,
				"classsDocentLectures" => $classsDocentLectures
		);

		T::render(self::$CTR."/index.php", self::$CTR."/nav.php", $variables);
	}
}
?>