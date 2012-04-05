<?php
class Unique extends Constraint {
	public function getSQL() {
		$attrs = Enum::enum($this->attributes, "getName");
		return "UNIQUE ($attrs)";
	}
	
	public function check($modelName) {
		//Nothing changed? Still satisfied
		if (count($this->getAlteredAttributes()) == 0) return true;
		
		$names = Enum::enum($this->attributes, "getName");
		
		$comps = "";
		$values = array();
		foreach ($this->attributes as $attribute) {
			$comps .= $attribute->getName() . "=" . $attribute->getDataType()->getFormatter() . " AND ";
			array_push($values, $attribute->getValue());
		}
		$comps = substr($comps, 0, strlen($comps) - 5);
		
		$sql = Sql::execute("SELECT $attrs FROM $modelName WHERE $comps", $values);
		
		//If count > 0: not unique
		if (count($sql->getResult()) > 0) throw new Exception("Attributes are not unique");
		
		return true;
	}
}