<?php
class PrimaryKey extends Unique{
	public function __construct(array $attributes) {
		parent::__construct("PK", $attributes);
		foreach ($attributes as $attribute)
			$attribute->setNullable(false);
	}

	public function getSql() {
		$attrs = Util::enum($this->attributes, "getName", ",", "`", "`");
		return "PRIMARY KEY ($attrs)";
	}
}

?>