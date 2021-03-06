<?php
namespace TYPO3\FLOW3\Tests\Unit\Package\Documentation;

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
 * Testcase for the documentation format class
 *
 */
class FormatTest extends \TYPO3\FLOW3\Tests\UnitTestCase {

	/**
	 * Sets up this test case
	 *
	 */
	protected function setUp() {
		\vfsStreamWrapper::register();
		\vfsStreamWrapper::setRoot(new \vfsStreamDirectory('testDirectory'));
	}

	/**
	 * @test
	 */
	public function constructSetsNameAndPathToFormat() {
		$documentationPath = \vfsStream::url('testDirectory') . '/';

		$format = new \TYPO3\FLOW3\Package\Documentation\Format('DocBook', $documentationPath);

		$this->assertEquals('DocBook', $format->getFormatName());
		$this->assertEquals($documentationPath, $format->getFormatPath());
	}

	/**
	 * @test
	 */
	public function getLanguagesScansFormatDirectoryAndReturnsLanguagesAsStrings() {
		$formatPath = \vfsStream::url('testDirectory') . '/';

		\TYPO3\FLOW3\Utility\Files::createDirectoryRecursively($formatPath . 'en');

		$format = new \TYPO3\FLOW3\Package\Documentation\Format('DocBook', $formatPath);
		$availableLanguages = $format->getAvailableLanguages();

		$this->assertEquals(array('en'), $availableLanguages);
	}
}
?>