<?php
declare(strict_types=1);

namespace CommutingAllowance\Transport;

use CommutingAllowance\AllowanceCalculator\CommonAllowanceCalculator;

class Bus implements TransportInterface {

	private const NAME = 'Bus';

	/** @var CommonAllowanceCalculator $allowanceCalculator */
	private $allowanceCalculator;

	/**
	 * Bus constructor.
	 * @param array $appConfiguration application configuration array from config.ini
	 */
	public function __construct(array $appConfiguration) {
		$this->allowanceCalculator = new CommonAllowanceCalculator(
			(float)$appConfiguration['compensation_per_km'][self::NAME]
		);
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