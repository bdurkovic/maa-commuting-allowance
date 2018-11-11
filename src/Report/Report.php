<?php

namespace CommutingAllowance\Report;

class Report {

	/** @var string $filename */
	private $filename;

	/** @var ReportLine[] $reportLines */
	private $reportLines;

	public function __construct(string $filename) {
		$this->filename    = $filename;
		$this->reportLines = [];
	}

	public function addLine(ReportLine $reportLine): void {
		$this->reportLines[] = $reportLine;
	}

	/**
	 * @param $month
	 * @param $year
	 * @return string
	 * @throws \Exception
	 */
	public function getPaymentDate($month, $year): string {
		$thisMonth = \DateTime::createFromFormat('j-n-Y', '1-'.$month.'-'.$year);
		return $thisMonth
			->add(new \DateInterval('P1M'))
			->modify('first monday')
			->format('d-m-Y');
	}

	public function getCurrencyFormat($amount): string {
		return sprintf('%01.2f', $amount);
	}

	public function generateOutputFile(): void {
		$this->setHeader();
		$outputFile = fopen($this->filename, 'wb');
		foreach($this->reportLines as $reportLine) {
			fputcsv($outputFile, explode(',', $reportLine->getLine()));
		}
	}

	private function setHeader(): void {
		header('Content-Type: text/csv');
		header('Content-Disposition: attachment; filename="'.$this->filename.'"');
	}

}