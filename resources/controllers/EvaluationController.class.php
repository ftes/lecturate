<?php
require_once(realpath(dirname(__FILE__) . "/../config.php"));

class EvaluationController extends AbstractController {
	
	private static $CTR = "evaluation";
	private static $TXT = "Evaluation";
	private static $URL_BASIS = "http://chart.apis.google.com/chart?";
	
	public static function index($_GET, $_POST) {
		T::render(self::$CTR."/default.php", self::$CTR."/nav.php", array());
	}
	
	private static function makeURL($chartType, $chartSize, $chartTitle, $chartLabels, $chartColors, $chartData) {
		$chartTypeURL = "cht=" . $chartType;
		$chartSizeURL = "chs=" . $chartSize;
		$chartTitleURL = "chtt=" . $chartTitle;
		$chartLabelsURL = "chl=" . $chartLabels;
		$chartColorsURL ="chco=" . $chartColors;
		
		for ($i = 0; $i < count($chartLabels); $i++) {
			$chartLabelsURL = $chartLabelsURL . $chartLabels[$i];
			if($i == (count($chartLabels)-1)) break;
			$chartLabelsURL = $chartLabelsURL . "|"; //Überall | anfügen, außer bei letztem
		}
	
		for ($i = 0; $i < count($chartLabels); $i++) {
			$chartColorsURL = $chartColorsURL . $chartColors[$i];
			if($i == (count($chartLabels)-1)) break;
			$chartColorsURL = $chartColorsURL . "|"; 
		}
		
		$chartDataURL = "chd=t:";
		for ($i = 0; $i < count($chartData); $i++) {
			$chartDataURL = $chartDataURL . $chartData[$i];
			if($i == (count($chartData)-1)) break;
			$chartDataURL = $chartDataURL . ","; 
		}
		$URL = self::$URL_BASIS . $chartTypeURL . "&" . $chartSizeURL . "&" . $chartDataURL . "&" . $chartLabelsURL . "&" . $chartTitleURL . "&" . $chartColorsURL;
		return $URL;
	}
	
	public static function evaluateAll() {
		$chartLabels = "1|2|3|4|5|6";
		$marks = array();
		$colors = array("0066FF","FFFF00","FF0000","00CC00");
		$ratings = Rating::findAll();
		foreach($ratings as $rating) {
			array_push($marks, $rating->getValue("mark"));	
		}
		$anzahl = array();
		for ($i = 0; $i < count($marks); $i++) {
			array_push($anzahl, Rating::findNumberOfMarks($marks[$i]));
			//liefert Fehler zurück
		}
		$variables = array(
				"evaluation"=>self::makeURL("p", "450x200", "Alle%20Vorlesungen", $marks, $colors, $anzahl)	
		);
		
		T::render(self::$CTR."/default.php", self::$CTR."/nav.php", $variables);
		
	} 
	
	
	
}
?>