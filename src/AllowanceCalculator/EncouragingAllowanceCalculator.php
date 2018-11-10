<?php
declare(strict_types=1);

namespace CommutingAllowance\AllowanceCalculator;

class EncouragingAllowanceCalculator implements AllowanceCalculatorInterface {

	private const BEGIN_ENCOURAGED_DISTANCE = 5.0;
	private const END_ENCOURAGED_DISTANCE = 10.0;
	private const ENCOURAGED_KILOMETERS_MULTIPLIER = 2.0;

	/** @var float $baseKilometerCompensation */
	private $baseKilometerCompensation;

	public function __construct(float $baseKilometerCompensation) {
		$this->baseKilometerCompensation = $baseKilometerCompensation;
	}

	/**
	 * calculates euro amount for allowance
	 *
	 * @param float $kilometers
	 * @return float
	 */
	public function getAllowance(float $kilometers): float {
		return
			(
				self::ENCOURAGED_KILOMETERS_MULTIPLIER * $this->getEncouragedKilometers($kilometers)
				+ $this->getCommonKilometers($kilometers)
			)
			* $this->baseKilometerCompensation;
	}

	/**
	 * gets amount of kilometers that are financially encouraged
	 *
	 * @param float $kilometers
	 * @return float
	 */
	private function getEncouragedKilometers(float $kilometers): float {
		if ($kilometers <= self::BEGIN_ENCOURAGED_DISTANCE) {
			// distance less than the encouraged one, no special encouraging
			return 0.0;
		} elseif ($kilometers <= self::END_ENCOURAGED_DISTANCE) {
			// the kilometers between the start and the end of the encouraged distance
			return $kilometers - self::BEGIN_ENCOURAGED_DISTANCE;
		} else {
			// all the specially encouraged kilometers are ridden
			return self::END_ENCOURAGED_DISTANCE - self::BEGIN_ENCOURAGED_DISTANCE;
		}
	}

	/**
	 * gets amount of kilometers that are not financially encouraged
	 *
	 * @param float $kilometers
	 * @return float
	 */
	private function getCommonKilometers(float $kilometers): float {
		return $kilometers - $this->getEncouragedKilometers($kilometers);
	}

}