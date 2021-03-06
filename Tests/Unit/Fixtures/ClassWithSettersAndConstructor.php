<?php
namespace TYPO3\FLOW3\Fixtures;

/*                                                                        *
 * This script belongs to the FLOW3 framework.                            *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU Lesser General Public License, either version 3   *
 * of the License, or (at your option) any later version.                 *
 *                                                                        *
 * The TYPO3 project - inspiring people to share!                         *
 *                                                                        */

/**
 * A dummy class with setters for testing data mapping
 *
 */
class ClassWithSettersAndConstructor {

	/**
	 * @var mixed
	 */
	protected $property1;

	/**
	 * @var mixed
	 */
	protected $property2;

	public function __construct($property1) {
		$this->property1 = $property1;
	}

	public function getProperty1() {
		return $this->property1;
	}

	public function getProperty2() {
		return $this->property2;
	}

	public function setProperty2($property2) {
		$this->property2 = $property2;
	}
}
?>
