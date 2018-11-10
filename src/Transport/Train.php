<?php
declare(strict_types=1);

namespace CommutingAllowance\Transport;

use CommutingAllowance\AllowanceCalculator\CommonAllowanceCalculator;

class Train implements TransportInterface {

	private const ALLOWANCE_PER_KM = 0.25;
	private const NAME = 'Train';

	/** @var CommonAllowanceCalculator $allowanceCalculator */
	private $allowanceCalculator;

	public function __construct() {
		$this->allowanceCalculator = new CommonAllowanceCalculator(self::ALLOWANCE_PER_KM);
	}

	public function calculateOneWayAllowance(float $kilometers): float {
		return $this->allowanceCalculator->getAllowance($kilometers);
	}

	public function calculateDayAllowance(float $kilometers): float {
		return 2 * $this->calculateOneWayAllowance($kilometers);
	}

	public function getName(): string {
		return self::NAME;
	}

}