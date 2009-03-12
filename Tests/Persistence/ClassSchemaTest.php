<?php
declare(ENCODING = 'utf-8');
namespace F3\FLOW3\Persistence;

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
 * @subpackage Persistence
 * @version $Id$
 */

/**
 * Testcase for the Class Schema.
 *
 * Note that many parts of the class schema functionality are already tested by the class
 * schema builder testcase.
 *
 * @package FLOW3
 * @subpackage Persistence
 * @version $Id$
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 */
class ClassSchemaTest extends \F3\Testing\BaseTestCase {

	/**
	 * @test
	 * @author Robert Lemke <robert@typo3.org>
	 */
	public function hasPropertyReturnsTrueOnlyForExistingProperties() {
		$classSchema = new \F3\FLOW3\Persistence\ClassSchema('SomeClass');
		$classSchema->setProperty('a', 'string');
		$classSchema->setProperty('b', 'integer');

		$this->assertTrue($classSchema->hasProperty('a'));
		$this->assertTrue($classSchema->hasProperty('b'));
		$this->assertFalse($classSchema->hasProperty('c'));
	}

	/**
	 * @test
	 * @author Karsten Dambekalns <karsten@typo3.org>
	 * @expectedException \InvalidArgumentException
	 */
	public function markAsIdentityPropertyRejectsUnknownProperties() {
		$classSchema = new \F3\FLOW3\Persistence\ClassSchema('SomeClass');

		$classSchema->markAsIdentityProperty('unknownProperty');
	}

	/**
	 * @test
	 * @author Karsten Dambekalns <karsten@typo3.org>
	 */
	public function getIdentityPropertiesReturnsNamesAndTypes() {
		$classSchema = new \F3\FLOW3\Persistence\ClassSchema('SomeClass');
		$classSchema->setProperty('a', 'string');
		$classSchema->setProperty('b', 'integer');

		$classSchema->markAsIdentityProperty('a');

		$this->assertSame(array('a' => 'string'), $classSchema->getIdentityProperties());
	}

}

?>