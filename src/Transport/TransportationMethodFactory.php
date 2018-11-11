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
	 * @param array $appConfiguration application configuration array from config.ini
	 * @return TransportInterface
	 */
	public static function createFromString(string $transportationMethod, array $appConfiguration): TransportInterface {
		$transportationMethod = __NAMESPACE__ . '\\' . $transportationMethod;
		if(!class_exists($transportationMethod)) {
			throw new \InvalidArgumentException(
				'Transportation method ' . $transportationMethod . ' is not supported.'
			);
		}

		return new $transportationMethod($appConfiguration);
	}

}