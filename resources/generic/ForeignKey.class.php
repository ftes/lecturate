<?php
class ForeignKey extends Constraint{
	private $referencedAttributes;
	private $referencedModel;
	
	public function __construct(array $attributes, Model $referencedModel, array $referencedAttributes) {
		parent::__construct($attributes);
		$this->referencedModel = $referencedModel;
		$this->referencedAttributes = $referencedAttributes;
	}
	
	public function getSQL() {
		$attrs = Enum::enum($this->attributes, "getName");
		$refAttrs = Enum::enum($this->referencedAttributes, "getName");
		$refMod = $this->referencedModel->getName();
		return "FOREIGN KEY ($cols) REFERENCES $refMod ($refAttrs)";
	}
	
	public function check($modelName) {
		//Nullable and all are Null -> satisfied
		if ($this->attributes[0]->getDataType()->getNullable()) {
			$allNull = true;
			foreach ($this->attributes as $attribute)
				if (! is_null($attribute->getValue()))
					$allNull = false;
			if ($allNull) return true;
		}
		
		//Valid FK?
		$names = Enum::enum($this->referencedAttributes, "getName");
		
		$values = Enum::getArray($this->attributes, "getValue");
		//we can use $this->attributes, as data format should be the same to FK table
		$comps = Enum::enum($this->attributes, "getComparator", " AND ");
		
		
		$refModName = $this->referencedModel->getName();
		$sql = Sql::execute("SELECT $names FROM $refModName WHERE $comps", $values);

		if ($sql->getResult()->num_rows < 1)
			throw new Exception("No matching foreign dataset found");
		
		return true;
	}	
}

?>