<?php

namespace CommutingAllowance\Report;

class Report {

	public function getPaymentDate($month, $year): string {
		$thisMonth  = \DateTime::createFromFormat('j-n-Y', '1-' . $month  . '-' . $year);
		return $thisMonth->add(new \DateInterval('P1M'))->modify('first monday')->format('d-m-Y');
	}

	public function getCurrencyFormat($amount): string {
		return sprintf('%01.2f',$amount);
	}

}