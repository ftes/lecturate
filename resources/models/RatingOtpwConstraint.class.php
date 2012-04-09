<?php

class ForeignRowExistsConstraint extends Constraint {
	private $referencedAttributes;
	private $referencedModel;
	public function __construct($name) {
		parent::__construct($name, $attributes);
		
	}
}