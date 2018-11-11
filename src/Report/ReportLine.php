<?php

namespace CommutingAllowance\Report;

class ReportLine {

	/** @var string $line */
	private $line;

	public function __construct() {
		$this->line = '';
	}

	public function getLine(): string {
		return $this->line;
	}

	public function addDataCell(string $cell): ReportLine {
		$this->line .= $cell.',';

		return $this;
	}

	public function endLine(): ReportLine {
		$this->line = substr($this->line, 0, -1);

		return $this;
	}

}