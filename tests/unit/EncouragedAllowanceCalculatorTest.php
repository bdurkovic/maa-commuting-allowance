<?php
declare(strict_types=1);

use CommutingAllowance\Transport\TransportationMethodFactory;

class EncouragedAllowanceCalculatorTest extends \Codeception\Test\Unit {
	/**
	 * @var \UnitTester
	 */
	protected $tester;

	protected function _before() {

	}

	protected function _after() {

	}

	public function testEncouragedAllowanceCalculator() {
		$appConfiguration = parse_ini_file('../../config.ini', true);
		$bike             = TransportationMethodFactory::createFromString('Bike', $appConfiguration);
		$employee         = new \CommutingAllowance\Employee('Matthijs', 11, 4.5, $bike);
		$this->assertEquals(368.0, $employee->getMonthlyAllowance(1, 2018));
	}
}