<?php
class ForeignKey extends Constraint{
	private $referencedAttributes;
	private $referencedModel;

	public function __construct(array $attributes, Model $referencedModel,
			array $referencedAttributes) {
		parent::__construct($referencedModel->getName(), $attributes);
		$this->referencedModel = $referencedModel;
		$this->referencedAttributes = $referencedAttributes;
	}

	public function getSql() {
		$attrs = Util::enum($this->attributes, "getName", ",", "`", "`");
		$refAttrs = Util::enum($this->referencedAttributes, "getName", ",", "`", "`");
		$refMod = $this->referencedModel->getName();
		return "FOREIGN KEY ($attrs) REFERENCES `$refMod` ($refAttrs)";
	}

	public function getError($modelName) {
		//Nullable and all are Null -> satisfied
		if ($this->attributes[0]->getNullable()) {
			$null = true;
			foreach ($this->attributes as $attribute)
				if (! is_null($attribute->getValue())) $null = false;
			if ($null) return false;
		}

		//Valid FK?
		$names = Util::enum($this->referencedAttributes, "getName");

		$values = Util::getArray($this->attributes, "getValue");
		//we can use $this->attributes, as data format should be the same to FK table
		$comps = Util::enum($this->referencedAttributes, "getComparator", " AND ");


		$refModName = $this->referencedModel->getName();
		$sql = Sql::execute("SELECT $names FROM $refModName WHERE $comps", $values);

		if (! $sql->getResult() || $sql->getResult()->num_rows < 1)
			return "existiert nicht";

		return false;
	}
}

?>