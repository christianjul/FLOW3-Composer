<?php
declare(ENCODING = 'utf-8');
namespace F3\FLOW3\Property;

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

require_once (__DIR__ . '/../Fixtures/ClassWithSetters.php');

/**
 * Testcase for the Property Mapper
 *
 * @package FLOW3
 * @subpackage Tests
 * @version $Id$
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 */
class MapperTest extends \F3\Testing\BaseTestCase {

	protected $mockObjectFactory;
	protected $mappingResults;

	/**
	 * Sets up this test case
	 *
	 * @return void
	 * @author Robert Lemke <robert@typo3.org>
	 */
	public function setUp() {
		$this->mappingResults = new \F3\FLOW3\Property\MappingResults();
		$this->mockObjectFactory = $this->getMock('F3\FLOW3\Object\FactoryInterface');
	}

	/**
	 * Checks if one ArrayObject can be bound to another by using the default settings
	 *
	 * @test
	 * @author Robert Lemke <robert@typo3.org>
	 */
	public function mapAndValidateCanCopyPropertiesOfOneArrayObjectToAnother() {
		$this->mockObjectFactory->expects($this->once())->method('create')->with('F3\FLOW3\Property\MappingResults')->will($this->returnValue($this->mappingResults));

		$target = new \ArrayObject();
		$source = new \ArrayObject(
			array(
				'key1' => 'value1',
				'key2' => 'Píca vailë yulda nár pé, cua téra engë centa oi.',
				'key3' => new \ArrayObject(
					array(
						'key3-1' => 'トワク びつける アキテクチャ エム, クリック'
					)
				),
				'key4' => array(
					'key4-1' => '@$ N0+ ||0t p@r+1cUL4r 7|24n5|473d'
				)
			)
		);

		$mapper = new \F3\FLOW3\Property\Mapper();
		$mapper->injectObjectFactory($this->mockObjectFactory);
		$successful = $mapper->mapAndValidate(array('key1', 'key2', 'key3', 'key4'), $source, $target);
		$this->assertEquals($source, $target);
		$this->assertTrue($successful);
	}

	/**
	 * @test
	 * @author Robert Lemke <robert@typo3.org>
	 * @expectedException \F3\FLOW3\Property\Exception\InvalidTargetObject
	 */
	public function mapAndValidateExpectsTheTargetToBeAnObject() {
		$this->mockObjectFactory->expects($this->once())->method('create')->with('F3\FLOW3\Property\MappingResults')->will($this->returnValue($this->mappingResults));

		$target = '';
		$source = new \ArrayObject(array('key1' => 'value1'));

		$mapper = new \F3\FLOW3\Property\Mapper();
		$mapper->injectObjectFactory($this->mockObjectFactory);
		$mapper->mapAndValidate(array('key1'), $source, $target);
	}

	/**
	 * Checks if mapping to a non-array target object via setter methods works
	 *
	 * @test
	 * @author Robert Lemke <robert@typo3.org>
	 */
	public function mapAndValidateCanCopyPropertiesFromAnArrayObjectToAnObjectWithSetters() {
		$this->mockObjectFactory->expects($this->at(0))->method('create')->with('F3\FLOW3\Property\MappingResults')->will($this->returnValue($this->mappingResults));
		$this->mockObjectFactory->expects($this->at(1))->method('create')->with('F3\FLOW3\Error\Error')->will($this->returnValue(new \F3\FLOW3\Error\Error('Error1', 1)));

		$target = new \F3\FLOW3\Fixture\Validation\ClassWithSetters();
		$source = new \ArrayObject (
			array(
				'property1' => 'value1',
				'property2' => 'Píca vailë yulda nár pé, cua téra engë centa oi.',
				'property4' => new \ArrayObject(
					array(
						'key3-1' => 'トワク びつける アキテクチャ エム, クリック'
					)
				),
				'property3' => array(
					'key4-1' => '@$ N0+ ||0t p@r+1cUL4r 7|24n5|473d'
				)
			)
		);

		$mapper = new \F3\FLOW3\Property\Mapper();
		$mapper->injectObjectFactory($this->mockObjectFactory);
		$result = $mapper->mapAndValidate(array('property1', 'property2', 'property3', 'property4'), $source, $target);

		$this->assertEquals($source['property1'], $target->property1, 'Property 1 has not the expected value.');
		$this->assertEquals(NULL, $target->getProperty2(), 'Property 2 is set although it should not, as there is no public setter and no public variable.');
		$this->assertEquals($source['property3'], $target->property3, 'Property 3 has not the expected value.');
		$this->assertEquals($source['property4'], $target->property4, 'Property 4 has not the expected value.');

		$this->assertEquals(FALSE, $result);

		$errors = $this->mappingResults->getErrors();
		$this->assertSame('Error1', $errors['property2']->getMessage());
	}

	/**
	 * @test
	 * @author Robert Lemke <robert@typo3.org>
	 */
	public function onlySpecifiedPropertiesAreMapped() {
		$this->mockObjectFactory->expects($this->once())->method('create')->with('F3\FLOW3\Property\MappingResults')->will($this->returnValue($this->mappingResults));

		$source = new \ArrayObject(
			array(
				'key1' => 'value1',
				'key2' => 'Píca vailë yulda nár pé, cua téra engë centa oi.',
				'key3' => 'value3',
				'key4' => array(
					'key4-1' => '@$ N0+ ||0t p@r+1cUL4r 7|24n5|473d'
				)
			)
		);

		$target = new \ArrayObject();

		$expectedTarget = new \ArrayObject(
			array(
				'key1' => $source['key1'],
				'key3' => $source['key3']
			)
		);

		$mapper = new \F3\FLOW3\Property\Mapper();
		$mapper->injectObjectFactory($this->mockObjectFactory);
		$mapper->mapAndValidate(array('key1', 'key3'), $source, $target);
		$this->assertEquals($expectedTarget, $target, 'The target object has not the expected content after allowing key1 and key3.');
	}

	/**
	 * @test
	 * @author Robert Lemke <robert@typo3.org>
	 */
	public function noPropertyIsMappedIfNoPropertiesWereSpecified() {
		$this->mockObjectFactory->expects($this->once())->method('create')->with('F3\FLOW3\Property\MappingResults')->will($this->returnValue($this->mappingResults));

		$source = new \ArrayObject(
			array(
				'key1' => 'value1',
				'key2' => 'Píca vailë yulda nár pé, cua téra engë centa oi.',
				'key3' => 'value3',
				'key4' => array(
					'key4-1' => '@$ N0+ ||0t p@r+1cUL4r 7|24n5|473d'
				)
			)
		);

		$target = new \ArrayObject();

		$expectedTarget = new \ArrayObject;

		$mapper = new \F3\FLOW3\Property\Mapper();
		$mapper->injectObjectFactory($this->mockObjectFactory);
		$mapper->mapAndValidate(array(), $source, $target);
		$this->assertEquals($expectedTarget, $target);
	}

	/**
	 * @test
	 * @author Sebastian Kurfürst <sebastian@typo3.org>
	 * @author Robert Lemke <robert@typo3.org>
	 */
	public function anObjectCanBeMappedToAnotherObject() {
		$this->mockObjectFactory->expects($this->once())->method('create')->with('F3\FLOW3\Property\MappingResults')->will($this->returnValue($this->mappingResults));

		$source = new \F3\FLOW3\Fixture\Validation\ClassWithSetters();
		$source->setProperty1('Hallo');
		$source->setProperty3('It is already late in the evening and I am curious which special characters my mac keyboard can do. «∑€®†Ω¨⁄øπ•±å‚∂ƒ©ªº∆@œæ¥≈ç√∫~µ∞…––çµ∫≤∞. Amazing :-) ');

		$target = new \F3\FLOW3\Fixture\Validation\ClassWithSetters();
		$mapper = new \F3\FLOW3\Property\Mapper();
		$mapper->injectObjectFactory($this->mockObjectFactory);
		$mapper->mapAndValidate(array('property1', 'property3'), $source, $target);
		$this->assertEquals($source, $target);
	}

	/**
	 * @test
	 * @author Robert Lemke <robert@typo3.org>
	 */
	public function ifAPropertyNameWasSpecifiedAndIsNotOptionalButDoesntExistInTheSourceTheMappingFails() {
		$this->mockObjectFactory->expects($this->at(0))->method('create')->with('F3\FLOW3\Property\MappingResults')->will($this->returnValue($this->mappingResults));
		$this->mockObjectFactory->expects($this->at(1))->method('create')->with('F3\FLOW3\Error\Error')->will($this->returnValue(new \F3\FLOW3\Error\Error('Error1', 1)));

		$target = new \ArrayObject();
		$source = new \ArrayObject(
			array(
				'key1' => 'value1',
				'key2' => 'value2'
			)
		);

		$mapper = new \F3\FLOW3\Property\Mapper();
		$mapper->injectObjectFactory($this->mockObjectFactory);
		$successful = $mapper->mapAndValidate(array('key1', 'key2', 'key3', 'key4'), $source, $target, array('key4'));
		$this->assertFalse($successful);
		$errors = $this->mappingResults->getErrors();
		$this->assertSame('Error1', $errors['key3']->getMessage());
	}


}
?>