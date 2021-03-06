<?php
namespace TYPO3\FLOW3\Persistence\Generic\Qom;

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
 * Evaluates to the lower-case string value (or values, if multi-valued) of
 * operand.
 *
 * If operand does not evaluate to a string value, its value is first converted
 * to a string.
 *
 * If operand evaluates to null, the LowerCase operand also evaluates to null.
 *
 * @api
 */
class LowerCase extends \TYPO3\FLOW3\Persistence\Generic\Qom\DynamicOperand {

	/**
	 * @var \TYPO3\FLOW3\Persistence\Generic\Qom\DynamicOperand
	 */
	protected $operand;

	/**
	 * Constructs this LowerCase instance
	 *
	 * @param \TYPO3\FLOW3\Persistence\Generic\Qom\DynamicOperand $operand
	 */
	public function __construct(\TYPO3\FLOW3\Persistence\Generic\Qom\DynamicOperand $operand) {
		$this->operand = $operand;
	}

	/**
	 * Gets the operand whose value is converted to a lower-case string.
	 *
	 * @return \TYPO3\FLOW3\Persistence\Generic\Qom\DynamicOperand the operand; non-null
	 * @api
	 */
	public function getOperand() {
		return $this->operand;
	}

}
?>