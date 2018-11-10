<?php
declare(strict_types=1);

namespace CommutingAllowance;

use CommutingAllowance\Transport\TransportInterface;

class Employee {

	private const WORKING_DAYS_ENUM = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri'];

	/** @var string $name */
	private $name;

	/** @var int $distance */
	private $distance;

	/** @var float $workdays */
	private $workdays;

	/** @var TransportInterface $vehicle */
	private $vehicle;

	public function __construct(string $name, int $distance, float $workdays, TransportInterface $vehicle) {
		$this->name = $name;
		$this->distance = $distance;
		$this->workdays = $workdays;
		$this->vehicle = $vehicle;
	}

	/**
	 * @return string
	 */
	public function getName(): string {
		return $this->name;
	}

	/**
	 * @return int
	 */
	public function getDistance(): int {
		return $this->distance;
	}

	/**
	 * @return float
	 */
	public function getWorkdays(): float {
		return $this->workdays;
	}

	/**
	 * @return TransportInterface
	 */
	public function getVehicle(): TransportInterface {
		return $this->vehicle;
	}

	/**
	 * return the days of the week where employee is present in the office
	 * Assumption: they are the first N weekdays
	 * Alternative: get the days of the week in the input
	 *
	 * @return array
	 */
	private function getOfficePresenceWeekdays(): array {
		$retVal = [];
		for($i = 0; $i < (int)ceil($this->workdays); $i++) {
			$retVal[] = self::WORKING_DAYS_ENUM[$i];
		}
		return $retVal;
	}

	private function getMonthlyPresenceDays(int $month, int $year): int {
		$presenceDays = 0;
		$currentDay   = \DateTime::createFromFormat('j-n-Y', '1-' . $month . '-' . $year);
		$officePresenceWeekdays = $this->getOfficePresenceWeekdays();
		while($currentDay->format('n') === (string)$month) {
			if(\in_array($currentDay->format('D'), $officePresenceWeekdays, true)) {
				$presenceDays++;
			}
			$currentDay->add(new \DateInterval('P1D'));
		}
		return $presenceDays;
	}

	public function getMonthlyAllowance(int $month, int $year): float {
		return $this->getMonthlyPresenceDays($month, $year) * $this->vehicle->calculateDayAllowance($this->distance);
	}

	public function getTraveledDistanceByMonth(int $month, int $year): float {
		return $this->distance * 2 * $this->getMonthlyPresenceDays($month, $year);
	}

}