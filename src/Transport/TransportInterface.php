<?php
declare(strict_types=1);

namespace CommutingAllowance\Transport;

interface TransportInterface {

	public function getName(): string;

	public function calculateOneWayAllowance(float $kilometers): float;

	public function calculateDayAllowance(float $kilometers): float;

}