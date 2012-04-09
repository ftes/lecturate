<?php
class Unique extends Constraint {
	
	public function getSql() {
		$attrs = Util::enum($this->attributes, "getName", "," ,"`", "`");
		return "UNIQUE ($attrs)";
	}

	public function getError($modelName) {		
		//Nothing changed? Still satisfied
		if (count($this->getAlteredAttributes()) == 0) return false;
		
		$names = Util::enum($this->attributes, "getName", ",", "`", "`");
		
		$values = Util::getArray($this->attributes, "getValue");
		$comps = Util::enum($this->attributes, "getComparator", " AND ");

		$sql = Sql::execute("SELECT $names FROM `$modelName` WHERE $comps", $values);
		
		//If count > 0: not unique
		if ($sql->getResult()->num_rows > 0)
			return "existiert bereits";
		
		return false;
	}
}