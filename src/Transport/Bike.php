<?php
declare(strict_types=1);

namespace CommutingAllowance\Transport;

use CommutingAllowance\AllowanceCalculator\EncouragingAllowanceCalculator;

class Bike implements TransportInterface {

	private const ALLOWANCE_PER_KM = 0.5;

	/** @var EncouragingAllowanceCalculator $allowanceCalculator */
	private $allowanceCalculator;

	public function __construct() {
		$this->allowanceCalculator = new EncouragingAllowanceCalculator(self::ALLOWANCE_PER_KM);
	}

	public function calculateOneWayAllowance(float $kilometers): float {
		return $this->allowanceCalculator->getAllowance($kilometers);
	}

	public function calculateDayAllowance(float $kilometers): float {
		return 2 * $this->calculateOneWayAllowance($kilometers);
	}

}