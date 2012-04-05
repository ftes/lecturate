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
		
		$values = Enum::getArray($this->attributes, "getValue");
		$comps = Enum::enum($this->attributes, "getComparator", " AND ");

		$sql = Sql::execute("SELECT $names FROM $modelName WHERE $comps", $values);
		
		//If count > 0: not unique
		if ($sql->getResult()->num_rows > 0)
			throw new Exception("Attributes are not unique");
		return true;
	}
}