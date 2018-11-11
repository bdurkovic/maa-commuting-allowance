<?php
declare(strict_types=1);

namespace CommutingAllowance\AllowanceCalculator;

class EncouragingAllowanceCalculator implements AllowanceCalculatorInterface {

	/** @var float $baseKilometerCompensation */
	private $baseKilometerCompensation;
	/** @var float $beginEncouragedDistance */
	private $beginEncouragedDistance;
	/** @var float $endEncouragedDistance */
	private $endEncouragedDistance;
	/** @var float $allowanceMultiplier */
	private $allowanceMultiplier;

	public function __construct(
		float $baseKilometerCompensation,
		float $beginEncouragedDistance,
		float $endEncouragedDistance,
		float $allowanceMultiplier
	) {
		$this->baseKilometerCompensation = $baseKilometerCompensation;
		$this->beginEncouragedDistance = $beginEncouragedDistance;
		$this->endEncouragedDistance = $endEncouragedDistance;
		$this->allowanceMultiplier = $allowanceMultiplier;
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
				$this->allowanceMultiplier * $this->getEncouragedKilometers($kilometers)
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
		if ($kilometers <= $this->beginEncouragedDistance) {
			// distance less than the encouraged one, no special encouraging
			return 0.0;
		} elseif ($kilometers <= $this->endEncouragedDistance) {
			// the kilometers between the start and the end of the encouraged distance
			return $kilometers - $this->beginEncouragedDistance;
		} else {
			// all the specially encouraged kilometers are ridden
			return $this->endEncouragedDistance - $this->beginEncouragedDistance;
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