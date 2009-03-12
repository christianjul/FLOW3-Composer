<?php
declare(ENCODING = 'utf-8');
namespace F3\FLOW3\Package;

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
 * @subpackage Tests
 * @version $Id$
 */

/**
 * Testcase for the package class
 *
 * @package FLOW3
 * @subpackage Tests
 * @version $Id$
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 */
class PackageTest extends \F3\Testing\BaseTestCase {

	/**
	 * @test
	 * @expectedException \F3\FLOW3\Package\Exception\InvalidPackagePath
	 * @author  Robert Lemke <robert@typo3.org>
	 */
	public function constructThrowsPackageDoesNotExistException() {
		$mockPackageManager = $this->getMock('F3\FLOW3\Package\Manager', array(), array(), '', FALSE);
		new \F3\FLOW3\Package\Package('TestPackage', './ThisPackageSurelyDoesNotExist', $mockPackageManager);
	}

	/**
	 * @test
	 * @expectedException \F3\FLOW3\Package\Exception\InvalidPackageKey
	 * @author Robert Lemke <robert@typo3.org>
	 */
	public function constructRejectsInvalidPackageKeys() {
		$mockPackageManager = $this->getMock('F3\FLOW3\Package\Manager', array(), array(), '', FALSE);
		new \F3\FLOW3\Package\Package('Invalid_Package_Key', './TestPackage/', $mockPackageManager);
	}

	/**
	 * @test
	 * @author Christopher Hlubek <hlubek@networkteam.com>
	 * @author Robert Lemke <robert@typo3.org>
	 */
	public function getPackageMetaDataUsesMetaDataReader() {
		$mockMetaData = $this->getMock('F3\FLOW3\Package\MetaDataInterface');
		$mockMetaDataReader = $this->getMock('F3\FLOW3\Package\MetaData\ReaderInterface');

		$package = new Package('FLOW3', FLOW3_PATH_FLOW3);
		$package->injectMetaDataReader($mockMetaDataReader);

		$mockMetaDataReader->expects($this->once())
			->method('readPackageMetaData')
			->will($this->returnValue($mockMetaData));

		$this->assertSame($mockMetaData, $package->getPackageMetaData());
	}

	/**
	 * @test
	 * @author Robert Lemke <robert@typo3.org>
	 */
	public function getPackageMetaDataPathReturnsPathToMetaDirectory() {
		$package = new \F3\FLOW3\Package\Package('FLOW3', FLOW3_PATH_FLOW3);
		$packageMetaDataPath = $package->getPackageMetaDataPath();

		$this->assertSame($package->getPackagePath() . \F3\FLOW3\Package\Package::DIRECTORY_METADATA, $packageMetaDataPath);
	}
}
?>