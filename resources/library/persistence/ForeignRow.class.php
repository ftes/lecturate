<?php
class ForeignRow extends ForeignKey{
	public function __construct($attributes, $referencedModel, $referencedAttributes) {
		parent::__construct($attributes, $referencedModel, $referencedAttributes);
		$this->name = "Zeile " . $referencedModel->getName();
	}
	
	public function getSql() {
		return "";
	}
}

?>