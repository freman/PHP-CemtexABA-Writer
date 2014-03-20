<?php namespace fremnet\cemtexaba\writer\record\detail;

/**
 * Cemtext ABA Detail Record Indicators
 *
 * @version 1.0.0
 * @author Shannon Wynter (http://fremnet.net/contact)
 * @copyright Copyright (c) 2014, Shannon Wynter (Fremnet)
 * @license http://www.gnu.org/licenses/gpl-2.0.html GPL 2.0 or greater
 * @package Fremnet
 * @subpackage CemtextABA
 */
class Indicator {
	/** No indicator **/
	const None = ' ';

	/** New or varied Bank/State/Branch number or name details **/
	const NewOrVaried = 'N';

	/** Dividend paid to a resident of a country where a double tax agreement is in force. **/
	const DoubleTaxDividend = 'W';

	/** Dividend paid to a resident of any other country. **/
	const OtherCountryDividend = 'X';

	/** Interest paid to all non-residents. **/
	const InterestPaidNonResident = 'Y';

	/** var string **/
	private $value = self::None;

	/**
	 * Constructor
	 *
	 * @param string $value
	 */
	private function __construct($value) {
		$this->value = $value;
	}

	/**
	 * Magic string method
	 */
	public function __toString() {
		return $this->value;
	}

	/**
	 * No indicator
	 *
	 * @return Indicator
	 **/
	static public function None() {
		return new self(self::None);
	}

	/**
	 * New or varied Bank/State/Branch number or name details
	 *
	 * @return Indicator
	 **/
	static public function NewOrVaried() {
		return new self(self::NewOrVaried);
	}

	/**
	 * Dividend paid to a resident of a country where a double tax agreement is in force.
	 *
	 * @return Indicator
	 **/
	static public function DoubleTaxDividend() {
		return new self(self::DoubleTaxDividend);
	}

	/**
	 * Dividend paid to a resident of any other country.
	 *
	 * @return Indicator
	 **/
	static public function OtherCountryDividend() {
		return new self(self::OtherCoutnryDividend);
	}

	/**
	 * Interest paid to all non-residents.
	 *
	 * @return Indicator
	 **/
	static public function InterestPaidNonResident() {
		return new self(self::InterestPaidNonResident);
	}
}
