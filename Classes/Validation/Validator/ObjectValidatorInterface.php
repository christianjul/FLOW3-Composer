<?php
declare(ENCODING = 'utf-8');
namespace F3\FLOW3\Validation\Validator;

/*                                                                        *
 * This script belongs to the FLOW3 framework.                            *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU Lesser General Public License as published by the *
 * Free Software Foundation, either version 3 of the License, or (at your *
 * option) any later version.                                             *
 *                                                                        *
 * This script is distributed in the hope that it will be useful, but     *
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHAN-    *
 * TABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Lesser       *
 * General Public License for more details.                               *
 *                                                                        *
 * You should have received a copy of the GNU Lesser General Public       *
 * License along with the script.                                         *
 * If not, see http://www.gnu.org/licenses/lgpl.html                      *
 *                                                                        *
 * The TYPO3 project - inspiring people to share!                         *
 *                                                                        */

/**
 * @package FLOW3
 * @subpackage Validation
 * @version $Id$
 */

/**
 * Contract for an object validator
 *
 * @package FLOW3
 * @subpackage Validation
 * @version $Id$
 * @author Robert Lemke <robert@typo3.org>
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 */
interface ObjectValidatorInterface extends \F3\FLOW3\Validation\Validator\ValidatorInterface {

	/**
	 * Checks if objects of the given type can be validated by the validator implementation
	 *
	 * @param string $className Name of the class which should be validated.
	 * @return boolean TRUE if this validator can validate instances of the given class or FALSE if it can't
	 */
	public function canValidateType($className);

	/**
	 * Checks if the specified property of the given object is valid.
	 *
	 * If at least one error occurred, the result is FALSE and any errors will
	 * be stored in the given errors object.
	 *
	 * Depending on the validator implementation, additional options may be passed
	 * in an array.
	 *
	 * @param object $object The object containing the property to validate
	 * @param string $propertyName Name of the property to validate
	 * @param \F3\FLOW3\Validation\Errors $errors An Errors object which will contain any errors which occurred during validation
	 * @param array $validationOptions An optional array of further options, specific to the validator implementation
	 * @return boolean TRUE if the property value is valid, FALSE if an error occured
	 * @author Robert Lemke <robert@typo3.org>
	 */
	public function hasValidProperty($object, $propertyName, \F3\FLOW3\Validation\Errors $errors, array $validationOptions = array());

	/**
	 * Checks if the given value would be valid as the specified property of the given class.
	 *
	 * If at least one error occurred, the result is FALSE and any errors will
	 * be stored in the given errors object.
	 *
	 * Depending on the validator implementation, additional options may be passed
	 * in an array.
	 *
	 * @param string $className Name of the class which would contain the property
	 * @param string $propertyName Name of the property
	 * @param string $propertyValue The value to validate as a potential property of the given class
	 * @param \F3\FLOW3\Validation\Errors $errors An Errors object which will contain any errors which occurred during validation
	 * @param array $validationOptions An optional array of further options, specific to the validator implementation
	 * @return boolean TRUE if the property value is valid, FALSE if an error occured
	 * @author Robert Lemke <robert@typo3.org>
	 */
	public function isValidProperty($className, $propertyName, $propertyValue, \F3\FLOW3\Validation\Errors $errorsm, array $validationOptions = array());
}

?>