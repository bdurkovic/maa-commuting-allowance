<?php
declare(strict_types=1);

namespace CommutingAllowance\AllowanceCalculator;

interface AllowanceCalculatorInterface {

	public function getAllowance(float $kilometers): float;

}