<?php
require_once(realpath(dirname(__FILE__) . "/../config.php"));

class EvaluationController extends AbstractController {
	
	private static $CTR = "evaluation";
	private static $TXT = "Evaluation";
	private static $URL_BASIS = "http://chart.apis.google.com/chart?";
	
	public static function index($_GET, $_POST) {
		T::render(self::$CTR."/default.php", self::$CTR."/nav.php", array());
	}
	
	private static function makeURL($chartType, $chartSize, $chartTitle, $chartLabels, $chartColors) {
		$chartTypeURL = "cht=" . $chartType;
		$chartSizeURL = "chs=" . $chartSize;
		$chartTitleURL = "chtt=" . $chartTitle;
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
		
		
		$yaxis = "chxr=0,0," . $maxCount . ",1";
		
		
		$URL = self::$URL_BASIS . $yaxis . "&chxt=y,x" . "&" . $chartTypeURL . "&" . $chartSizeURL . "&" . $chartDataURL . "&" . $chartLabelsURL . "&" . $chartTitleURL . "&" . $chartColorsURL;
		echo $URL;
		return $URL;
	}
	
	public static function evaluateAll() {
		$marks = array();
		$colors = array("00CD00","7FFF00","FFD700","FF6347","FF3030");
		$ratings = Rating::findAll();
		
		foreach($ratings as $rating) {
			$mark = $rating->getValue("mark");
			if (! array_key_exists($mark, $marks)) $marks[$mark] = 0;
			$marks[$mark]++;
		}
		

		$variables = array(
				"evaluation"=>self::makeURL("bvg", "450x200", "Alle%20Vorlesungen", $marks, $colors)	
		);
		
		T::render(self::$CTR."/default.php", self::$CTR."/nav.php", $variables);
		
	} 
	
	
	
}
?>