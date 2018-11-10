<?php
declare(strict_types=1);

use CommutingAllowance\Transport\TransportationMethodFactory;

require_once dirname(__DIR__) . '/vendor/autoload.php';

echo 'test';

$testEmployee = new \CommutingAllowance\Employee(
	'Bojan', 25, 4.5, TransportationMethodFactory::createFromString('Bike')
);

echo 'commuting allowance for ' . $testEmployee->getName() . ' for one week is ' . $testEmployee->calculateWeeklyAllowance();