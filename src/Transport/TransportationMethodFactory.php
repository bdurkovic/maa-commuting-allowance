<?php
declare(strict_types=1);

namespace CommutingAllowance\Transport;

/**
 * Class TransportationMethodFactory instantiates one of the supported Transport classes
 * @package CommutingAllowance\Transport
 */
class TransportationMethodFactory {

	/**
	 * Instantiates $transportationMethod
	 *
	 * @param string $transportationMethod
	 * @return TransportInterface
	 */
	public static function createFromString(string $transportationMethod): TransportInterface {
		$transportationMethod = __NAMESPACE__ . '\\' . $transportationMethod;
		if(!class_exists($transportationMethod)) {
			throw new \InvalidArgumentException(
				'Transportation method ' . $transportationMethod . ' is not supported.'
			);
		}

		return new $transportationMethod();
	}

}