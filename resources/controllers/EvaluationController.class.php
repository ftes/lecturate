<?php
require_once(realpath(dirname(__FILE__) . "/../config.php"));

class EvaluationController extends AbstractController {
	
	public static function evaluation_date() {
		$DataSet->SetSerieName("Wann wurde die Vorlesung bewertet?","Serie1");
		$ratings = Rating::findAll();
		foreach ($ratings as &$date) {
			$value = getValues("Created");
			$i += 0;
			$DataSet->AddPoint($row[$value],"Serie" . $i);
		}
		$DataSet->AddAllSeries();
	} 
	
}
?>