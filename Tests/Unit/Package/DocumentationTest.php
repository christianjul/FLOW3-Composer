<?php
namespace TYPO3\FLOW3\Tests\Unit\Package;

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
 * Testcase for the package documentation class
 *
 */
class DocumentationTest extends \TYPO3\FLOW3\Tests\UnitTestCase {

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
	public function constructSetsPackageNameAndPathToDocumentation() {
		$documentationPath = \vfsStream::url('testDirectory') . '/';

		$mockPackage = $this->getMock('TYPO3\FLOW3\Package\PackageInterface');

		$documentation = new \TYPO3\FLOW3\Package\Documentation($mockPackage, 'Manual', $documentationPath);

		$this->assertSame($mockPackage, $documentation->getPackage());
		$this->assertEquals('Manual', $documentation->getDocumentationName());
		$this->assertEquals($documentationPath, $documentation->getDocumentationPath());
	}

	/**
	 * @test
	 */
	public function getDocumentationFormatsScansDocumentationDirectoryAndReturnsDocumentationFormatObjectsIndexedByFormatName() {
		$documentationPath = \vfsStream::url('testDirectory') . '/';

		$mockPackage = $this->getMock('TYPO3\FLOW3\Package\PackageInterface');

		\TYPO3\FLOW3\Utility\Files::createDirectoryRecursively($documentationPath . 'DocBook/en');

		$documentation = new \TYPO3\FLOW3\Package\Documentation($mockPackage, 'Manual', $documentationPath);
		$documentationFormats = $documentation->getDocumentationFormats();

		$this->assertEquals('DocBook', $documentationFormats['DocBook']->getFormatName());
	}
}
?>