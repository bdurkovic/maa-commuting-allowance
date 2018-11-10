<?php
declare(strict_types=1);

use CommutingAllowance\Transport\TransportationMethodFactory;

require_once dirname(__DIR__) . '/vendor/autoload.php';

$input = [
	[
		'employee' => 'Paul',
		'transport' => 'Car',
		'distance' => 60,
		'workdays' => 5
	],
	[
		'employee' => 'Martin',
		'transport' => 'Bus',
		'distance' => 8,
		'workdays' => 4
	],
	[
		'employee' => 'Jeroen',
		'transport' => 'Bike',
		'distance' => 9,
		'workdays' => 5
	],
	[
		'employee' => 'Tineke',
		'transport' => 'Bike',
		'distance' => 4,
		'workdays' => 3
	],
	[
		'employee' => 'Arnout',
		'transport' => 'Train',
		'distance' => 23,
		'workdays' => 5
	],
	[
		'employee' => 'Matthijs',
		'transport' => 'Bike',
		'distance' => 11,
		'workdays' => 4.5
	],
	[
		'employee' => 'Rens',
		'transport' => 'Car',
		'distance' => 12,
		'workdays' => 5
	]
];

$report = new CommutingAllowance\Report\Report();

foreach($input as $employeeArr) {
	$employee = new \CommutingAllowance\Employee(
		$employeeArr['employee'],
		$employeeArr['distance'],
		$employeeArr['workdays'],
		TransportationMethodFactory::createFromString($employeeArr['transport'])
	);

	for($month = 1; $month <= 12; $month++) {
		$csvRow =
			$employee->getName().','
			.$employee->getVehicle()->getName().','
			.$employee->getTraveledDistanceByMonth($month, 2018).'km,'
			.$report->getCurrencyFormat($employee->getMonthlyAllowance($month, 2018)).','
			.$report->getPaymentDate($month, 2018);

		echo $csvRow . "\n";
	}
}