<?php
class Reference extends Attribute {

	private $referencedModel;
	
	/**
	 * How to propagate changes to referenced row:
	 * RESTRICT | CASCADE | SET NULL | NO ACTION
	 * @var string
	 */
	private $propagate;
	
	public function __construct($name, Model $referencedModel, $nullable, $propagate) {
		parent::__construct($name, new Int($nullable));
		
		if (! is_string($propagate))
			throw new Exception("Reference: \$propagate has to be STRING");
		
		$this->referencedModel = $referencedModel;
		$this->propagate = $propagate;
	}
	
	public function getSQL() {
		return "{$this->getName()} {$this->getDataType()->getSQL()}, " .
			"FOREIGN KEY ({$this->getName()}) REFERENCES {$this->referencedModel->getName()} (id) " .
			"ON DELETE $this->propagate ON UPDATE $this->propagate";
	}
	
	public function getReference() {
		
	}
}
?>