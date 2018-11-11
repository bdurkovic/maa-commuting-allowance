<?php
declare(strict_types=1);

use CommutingAllowance\Transport\TransportationMethodFactory;
use CommutingAllowance\Report\Report;
use CommutingAllowance\Report\ReportLine;
use CommutingAllowance\Employee;

require_once dirname(__DIR__).'/vendor/autoload.php';

$appConfiguration = parse_ini_file(dirname(__DIR__).'/config.ini', true);

$input = [
	[
		'employee'  => 'Paul',
		'transport' => 'Car',
		'distance'  => 60,
		'workdays'  => 5
	],
	[
		'employee'  => 'Martin',
		'transport' => 'Bus',
		'distance'  => 8,
		'workdays'  => 4
	],
	[
		'employee'  => 'Jeroen',
		'transport' => 'Bike',
		'distance'  => 9,
		'workdays'  => 5
	],
	[
		'employee'  => 'Tineke',
		'transport' => 'Bike',
		'distance'  => 4,
		'workdays'  => 3
	],
	[
		'employee'  => 'Arnout',
		'transport' => 'Train',
		'distance'  => 23,
		'workdays'  => 5
	],
	[
		'employee'  => 'Matthijs',
		'transport' => 'Bike',
		'distance'  => 11,
		'workdays'  => 4.5
	],
	[
		'employee'  => 'Rens',
		'transport' => 'Car',
		'distance'  => 12,
		'workdays'  => 5
	]
];

/** @var Report $report */
$report = new Report('test.csv');

try {

	/** @var Employee[] $employees */
	$employees = [];

	foreach($input as $employeeArr) {
		$employees[] = new Employee(
			$employeeArr['employee'],
			$employeeArr['distance'],
			$employeeArr['workdays'],
			TransportationMethodFactory::createFromString($employeeArr['transport'], $appConfiguration)
		);
	}

	for($month = 1; $month <= 12; $month++) {
		$report->addLine(
			(new ReportLine())
				->addDataCell('Employee')
				->addDataCell('Transport')
				->addDataCell('Traveled distance')
				->addDataCell(
					'Compensation for '
					.DateTime::createFromFormat('!m', (string)$month)->format('F')
					.' 2018'
				)
				->addDataCell('Payment Date')
				->endLine()
		);

		foreach($employees as $employee) {
			$report->addLine(
				(new ReportLine())
					->addDataCell($employee->getName())
					->addDataCell($employee->getVehicle()->getName())
					->addDataCell($employee->getTraveledDistanceByMonth($month, 2018).'km')
					->addDataCell($report->getCurrencyFormat($employee->getMonthlyAllowance($month, 2018)))
					->addDataCell($report->getPaymentDate($month, 2018))
					->endLine()
			);
		}

	}
} catch(Exception $e) {
	$report->addLine(
		(new ReportLine())
			->addDataCell('An error has occurred: '.$e->getMessage())
			->endLine()
	);
}

$report->generateOutputFile();

