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

	/** @var array $officePresenceWeekdays array containing some of all members of self::WORKING_DAYS_ENUM */
	private $officePresenceWeekdays;

	public function __construct(string $name, int $distance, float $workdays, TransportInterface $vehicle) {
		if(empty($name) || $distance < 0 || $workdays < 1 || $workdays > \count(self::WORKING_DAYS_ENUM)) {
			throw new \InvalidArgumentException('Bad employee input');
		}

		$this->name     = $name;
		$this->distance = $distance;
		$this->workdays = $workdays;
		$this->vehicle  = $vehicle;
		$this->getOfficePresenceWeekdays();
	}

	/**
	 * @return string
	 */
	public function getName(): string {
		return $this->name;
	}

	/**
	 * @return TransportInterface
	 */
	public function getVehicle(): TransportInterface {
		return $this->vehicle;
	}

	/**
	 * sets the days of the week where employee is present in the office
	 * Assumption: they are the first N weekdays
	 * Alternative: get the days of the week in the input
	 */
	private function getOfficePresenceWeekdays(): void {
		$this->officePresenceWeekdays = [];
		for($i = 0; $i < (int)ceil($this->workdays); $i++) {
			$this->officePresenceWeekdays[] = self::WORKING_DAYS_ENUM[$i];
		}
	}

	/**
	 * Gets the amount of the days the employee is present in the office in a given month
	 *
	 * @param int $month
	 * @param int $year
	 * @return int
	 * @throws \Exception
	 */
	private function getMonthlyPresenceDays(int $month, int $year): int {
		$presenceDays = 0;

		// $currentDay begins as the first day of the given month and is incremented by one day in every loop iteration
		// for each day it is checked if its day of the week matches the weekdays the employee is in the office
		// if so, the return value is incremented by one
		// this is done for as long as the month of the day is still the given month
		$currentDay = \DateTime::createFromFormat('j-n-Y', '1-'.$month.'-'.$year);
		while($currentDay->format('n') === (string)$month) {
			if(\in_array($currentDay->format('D'), $this->officePresenceWeekdays, true)) {
				$presenceDays++;
			}
			$currentDay->add(new \DateInterval('P1D'));
		}
		return $presenceDays;
	}

	/**
	 * Gets monthly allowance for the given month, in euros
	 *
	 * @param int $month
	 * @param int $year
	 * @return float
	 * @throws \Exception
	 */
	public function getMonthlyAllowance(int $month, int $year): float {
		return $this->getMonthlyPresenceDays($month, $year) * $this->vehicle->calculateDayAllowance($this->distance);
	}

	/**
	 * Gets traveled distance for the given month, in kilometers
	 *
	 * @param int $month
	 * @param int $year
	 * @return float
	 * @throws \Exception
	 */
	public function getTraveledDistanceByMonth(int $month, int $year): float {
		return $this->distance * 2 * $this->getMonthlyPresenceDays($month, $year);
	}

}