<?php
declare(strict_types=1);

namespace CommutingAllowance\AllowanceCalculator;

class CommonAllowanceCalculator implements AllowanceCalculatorInterface {

	/** @var float $baseKilometerCompensation */
	private $baseKilometerCompensation;

	public function __construct(float $baseKilometerCompensation) {
		$this->baseKilometerCompensation = $baseKilometerCompensation;
	}

	/**
	 * return euro amount for allowance
	 *
	 * @param float $kilometers
	 * @return float
	 */
	public function getAllowance(float $kilometers): float {
		return $this->baseKilometerCompensation * $kilometers;
	}

}