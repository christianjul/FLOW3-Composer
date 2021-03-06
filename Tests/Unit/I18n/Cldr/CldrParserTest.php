<?php
namespace TYPO3\FLOW3\Tests\Unit\I18n\Cldr;

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
 * Testcase for the CldrParser
 *
 */
class CldrParserTest extends \TYPO3\FLOW3\Tests\UnitTestCase {

	/**
	 * @test
	 */
	public function parsesCldrDataCorrectly() {
		$sampleFilenamePath = __DIR__ . '/../Fixtures/MockCldrData.xml';
		$sampleParsedData = require(__DIR__ . '/../Fixtures/MockParsedCldrData.php');

		$parser = new \TYPO3\FLOW3\I18n\Cldr\CldrParser();

		$result = $parser->getParsedData($sampleFilenamePath);
		$this->assertEquals($sampleParsedData, $result);
	}
}

?>
