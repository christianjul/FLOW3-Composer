<?php
namespace TYPO3\FLOW3\Tests\Functional\Utility;

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
 * Functional test for the Now class
 */
class NowTest extends \TYPO3\FLOW3\Tests\FunctionalTestCase {

	/**
	 * @test
	 */
	public function nowReturnsAUniqueTimestamp() {
		$now = $this->objectManager->get('TYPO3\FLOW3\Utility\Now');
		$alsoNow = $this->objectManager->get('TYPO3\FLOW3\Utility\Now');
		$this->assertSame($now->getTimeStamp(), $alsoNow->getTimeStamp());
	}

}
?>