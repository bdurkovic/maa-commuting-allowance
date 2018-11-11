<?php
declare(strict_types=1);

namespace CommutingAllowance\Transport;

use CommutingAllowance\AllowanceCalculator\EncouragingAllowanceCalculator;

class Bike implements TransportInterface {

	private const NAME = 'Bike';

	/** @var EncouragingAllowanceCalculator $allowanceCalculator */
	private $allowanceCalculator;

	/**
	 * Bike constructor.
	 * @param array $appConfiguration application configuration array from config.ini
	 */
	public function __construct(array $appConfiguration) {
		$this->allowanceCalculator = new EncouragingAllowanceCalculator(
			(float)$appConfiguration['compensation_per_km'][self::NAME],
			(float)$appConfiguration['encouraged_distance']['begin'],
			(float)$appConfiguration['encouraged_distance']['end'],
			(float)$appConfiguration['encouraged_distance']['multiplier']
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