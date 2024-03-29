<?php
require_once(realpath(dirname(__FILE__) . "/../config.php"));

class EvaluationController extends AbstractController {

	private static $CTR = "evaluation";
	private static $TXT = "Auswertung";
	private static $URL_BASIS = "http://chart.apis.google.com/chart?";

	public static function index() {
		LoginController::login(T::href(self::$CTR, __FUNCTION__));

		self::evaluateAll();
	}

	private static function makeURL($chartType, $chartSize, $chartLabels,
			$chartColors) {
		$chartTypeURL = "cht=" . $chartType;
		$chartSizeURL = "chs=" . $chartSize;
		$chartBackgroundURL = "chf=bg,s,00000000";
		$chartLabelsURL = "chl=";
		$chartColorsURL = "chco=";
		$chartDataURL = "chd=t:";
		$maxCount = 0;
		$newCount = 0;

		foreach ($chartLabels as $mark=>$count) {
			if ($maxCount < $count) $maxCount = $count;
		}
		foreach ($chartLabels as $mark=>$count) {
			$chartLabelsURL = $chartLabelsURL . $mark;
			$chartLabelsURL = $chartLabelsURL . "|";
			$newCount = $count * (100/$maxCount);
			$chartDataURL = $chartDataURL . $newCount;
			$chartDataURL = $chartDataURL . ",";
			$chartColorsURL = $chartColorsURL . $chartColors[$mark-1];
			$chartColorsURL = $chartColorsURL . "|";
		}
		$chartLabelsURL = substr($chartLabelsURL, 0, strlen($chartLabelsURL)-1);
		$chartDataURL = substr($chartDataURL, 0, strlen($chartDataURL)-1);
		$chartColorsURL = substr($chartColorsURL, 0, strlen($chartColorsURL)-1);

		$step = floor($maxCount/5) + 1;
		$yaxis = "chxr=0,0," . $maxCount . "," . $step;


		$URL = self::$URL_BASIS . $yaxis
		. "&chxt=y,y,x,x&chxl=1:||Anzahl|3:|||||Note"
		. "&" . $chartTypeURL
		. "&" . $chartSizeURL
		. "&" . $chartDataURL
		. "&" . $chartLabelsURL
		. "&" . $chartColorsURL
		. "&" . $chartBackgroundURL;
		return $URL;
	}

	public static function evaluateAll() {
		LoginController::login(T::href(self::$CTR, __FUNCTION__));

		$marks = array();
		$colors = array("00CD00","7FFF00","FFD700","FF6347","FF3030");
		$ratings = Rating::findAll();
		$comments = array();
		$mittelwert = 0;

		for ($i=1; $i<=5; $i++)
			$marks[$i] = 0;

		foreach($ratings as $rating) {
			$mark = $rating->getValue("mark");
			$marks[$mark]++;
			$mittelwert = $mittelwert + $mark;
			if($rating->getValue("comment") != "")
				array_push($comments,$rating->getValue("comment"));
		}

		ksort($marks);
		$count = count($ratings);

		//! Divison by zero
		$mittelwert = $count==0 ? 0 : $mittelwert/$count;;
			
		$content = array("Mittelwert"=>round($mittelwert,2));

		$variables = array(
				"heading"=>self::$TXT." DHBW",
				"evaluation"=>self::makeURL("bvg", "250x250", $marks, $colors),
				"content"=>$content,
				"comments"=>$comments
		);

		T::render(self::$CTR."/default.php", self::$CTR."/nav.php", $variables);

	}

	public static function evaluateDocent() {
		LoginController::login(T::href(self::$CTR, __FUNCTION__));

		if ($id = self::get($_GET, "id"))
			if ($model = Docent::findById($id)) {

			$marks = array();
			$colors = array("00CD00","7FFF00","FFD700","FF6347","FF3030");
			$ratings = Rating::findByDocent($id); // dozentID muss mitgeben werden
			$comments = array();

			if (count($ratings) == 0) {
				$_SESSION["flash"] =
				array(T::FLASH_NEG, "Für diesen Dozent liegt keine Bewertung vor");
				Util::redirect(T::href("docent", "index"));
			}
			$mittelwert = 0;

			for ($i=1; $i<=5; $i++)
				$marks[$i] = 0;

			foreach($ratings as $rating) {
				$mark = $rating->getValue("mark");
				$marks[$mark]++;
				$mittelwert = $mittelwert + $mark;
				if($rating->getValue("comment") != "")
					array_push($comments,$rating->getValue("comment"));
			}

			ksort($marks);
			$mittelwert = $mittelwert/count($ratings);

			$content = array("Mittelwert"=>round($mittelwert,2));

			$variables = array(
					"heading"=>self::$TXT." Dozent: ".$model->toString(),
					"evaluation"=>self::makeURL("bvg", "250x250", $marks, $colors),
					"content"=>$content,
					"comments"=>$comments

			);

			T::render(self::$CTR."/default.php", self::$CTR."/nav.php", $variables);

			die();
		}

		$_SESSION["flash"] = array(T::FLASH_NEG,
				self::$TXT." konnte nicht gefunden werden");
		Util::redirect(T::href(self::$CTR, "index"));

			
	}

	public static function evaluateDocentLecture() {
		LoginController::login(T::href(self::$CTR, __FUNCTION__));

		if ($id = self::get($_GET, "id"))
			if ($model = Docent::findById($id)) {

			$marks = array();
			$colors = array("00CD00","7FFF00","FFD700","FF6347","FF3030");
			$ratings = Rating::findByDocentLecture($id); // dozentID muss mitgeben werden
			$comments = array();
			if (count($ratings) == 0) {
				$_SESSION["flash"] =
				array(T::FLASH_NEG, "Für diese Zuordnung liegt keine Bewertung vor");
				Util::redirect(T::href("docent_lecture", "index"));
			}
			$mittelwert = 0;

			for ($i=1; $i<=5; $i++)
				$marks[$i] = 0;
			foreach($ratings as $rating) {
				$mark = $rating->getValue("mark");
				$marks[$mark]++;
				$mittelwert = $mittelwert + $mark;
				if($rating->getValue("comment") != "")
					array_push($comments,$rating->getValue("comment"));
			}

			ksort($marks);
			$mittelwert = $mittelwert/count($ratings);

			$content = array("Mittelwert"=>round($mittelwert,2));

			$variables = array(
					"heading"=>self::$TXT." Dozent hält Vorlesung: ".$model->toString(),
					"evaluation"=>self::makeURL("bvg", "250x250", $marks, $colors),
					"content"=>$content,
					"comments"=>$comments

			);

			T::render(self::$CTR."/default.php", self::$CTR."/nav.php", $variables);

			die();
		}

		$_SESSION["flash"] = array(T::FLASH_NEG,
				self::$TXT." konnte nicht gefunden werden");
		Util::redirect(T::href(self::$CTR, "index"));
	}

	public static function evaluateLecture(){
		if ($id = self::get($_GET, "id"))
			if ($model = Lecture::findById($id)) {

			$marks = array();
			$colors = array("00CD00","7FFF00","FFD700","FF6347","FF3030");
			$ratings = Rating::findByLecture($id); //lecture ID
			$comments = array();
			if (count($ratings) == 0) {
				$_SESSION["flash"] =
				array(T::FLASH_NEG, "Für diese Vorlesung liegt keine Bewertung vor");
				Util::redirect(T::href("lecture", "index"));
			}
			$mittelwert = 0;
			for ($i=1; $i<=5; $i++)
				$marks[$i] = 0;
			foreach($ratings as $rating) {
				$mark = $rating->getValue("mark");

				$marks[$mark]++;
				$mittelwert = $mittelwert + $mark;
				if($rating->getValue("comment") != "")
					array_push($comments,$rating->getValue("comment"));
			}

			ksort($marks);
			$mittelwert = $mittelwert/count($ratings);

			$content = array("Mittelwert"=>round($mittelwert,2));
			$variables = array(
					"heading"=>self::$TXT." Vorlesung: ".$model->toString(),
					"evaluation"=>self::makeURL("bvg", "250x250", $marks, $colors),
					"content"=>$content,
					"comments"=>$comments

			);

			T::render(self::$CTR."/default.php", self::$CTR."/nav.php", $variables);

			die();
		}

		$_SESSION["flash"] = array(T::FLASH_NEG,
				self::$TXT." konnte nicht gefunden werden");
		Util::redirect(T::href(self::$CTR, "index"));

	}

}
?>
