<?php
class PrimaryKey extends Unique{
	public function __construct(array $attributes) {
		parent::__construct($attributes);
		foreach ($attributes as $attribute)
			$attribute->getDataType()->setNullable(false);
	}
	
	public function getSQL() {
		$attrs = Enum::enum($this->attributes, "getName");
		return "PRIMARY KEY ($attrs)";
	}
}

?>