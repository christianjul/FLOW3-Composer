<?php
namespace TYPO3\FLOW3\Utility\Unicode;

/*                                                                        *
 * This script belongs to the FLOW3 package "FLOW3".                      *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU Lesser General Public License, either version 3   *
 * of the License, or (at your option) any later version.                 *
 *                                                                        *
 * The TYPO3 project - inspiring people to share!                         *
 *                                                                        */

use TYPO3\FLOW3\Annotations as FLOW3;

/**
 * Exception thrown if a feature is not supported by the PHP6 backport code.
 *
 * @FLOW3\Scope("singleton")
 * @api
 */
class UnsupportedFeatureException extends \Exception {
}

?>