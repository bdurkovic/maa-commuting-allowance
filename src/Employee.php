<?php
declare(strict_types=1);

namespace CommutingAllowance;

use CommutingAllowance\Transport\TransportInterface;

class Employee {

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

	public function getWeeklyOfficePresenceDays(): int {
		return (int)ceil($this->workdays);
	}

	public function calculateWeeklyAllowance(): float {
		return $this->getWeeklyOfficePresenceDays() * $this->vehicle->calculateDayAllowance($this->distance);
	}

}