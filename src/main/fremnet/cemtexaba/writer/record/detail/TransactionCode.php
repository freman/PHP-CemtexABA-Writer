<?php namespace fremnet\cemtexaba\writer\record\detail;

/**
 * Cemtext ABA Detail Record Transaction Codes
 *
 * @version 1.0.0
 * @author Shannon Wynter (http://fremnet.net/contact)
 * @copyright Copyright (c) 2014, Shannon Wynter (Fremnet)
 * @license http://www.gnu.org/licenses/gpl-2.0.html GPL 2.0 or greater
 * @package Fremnet
 * @subpackage CemtextABA
 */
class TransactionCode {
	/** Externally initiated debit items **/
	const ExternalDebit                        = 13;

	/** Externally initiated credit items with the exception of those bearing Transaction Codes **/
	const ExternalCredit                       = 50;

	/** Australian Government Security Interest **/
	const AustralianGovernmentSecurityInterest = 51;

	/** Family Allowance **/
	const FamilyAllowance                      = 52;

	/** Payroll Pay **/
	const Pay                                  = 53;

	/** Pension **/
	const Pension                              = 54;

	/** Allotment **/
    const Allotment                            = 55;

	/** Dividend **/
	const Dividend                             = 56;

	/** Debenture/Note Interest **/
    const Debenture                            = 57;

	/** var int **/
	private $value = self::ExternalCredit;

	/** var [int] Codes that are crediting the account **/
	private static $credit_codes = [
		self::ExternalCredit,
		self::AustralianGovernmentSecurityInterest,
		self::FamilyAllowance,
		self::Pay,
		self::Pension,
		self::Allotment,
		self::Dividend,
		self::Debenture
	];

	/** var [int] Codes that are debiting the account **/
	private static $debit_codes = [
		self::ExternalDebit
	];

	/**
	 * Constructor
	 *
	 * @param string $value
	 */
	private function __construct($value) {
		$this->value = $value;
	}

	/**
	 * Is this transaction code a credit
	 *
	 * @return boolean
	 */
	public function is_credit() {
		return in_array($this->value, self::$credit_codes);
	}

	/**
	 * Is this transaction code a debit
	 *
	 * @return boolean
	 */
	public function is_debit() {
		return in_array($this->value, self::$debit_codes);
	}

	/**
	 * Magic string method
	 */
	public function __toString() {
		return (string)$this->value;
	}

	/**
	 * Externally initiated debit item transaction
	 *
	 * @return TransactionCode
	 **/
	static public function ExternalDebit() {
		return new self(self::ExternalDebit);
	}

	/**
	 * Externally initiated credit items with the exception of those bearing Transaction Codes
	 *
	 * @return TransactionCode
	 **/
	static public function ExternalCredit() {
		return new self(self::ExternalCredit);
	}

	/**
	 * Australian Government Security Interest transaction
	 *
	 * @return TransactionCode
	 **/
	static public function AustralianGovernmentSecurityInterest() {
		return new self(self::AustralianGovernmentSecurityInterest);
	}

	/**
	 * Family Allowance transaction
	 *
	 * @return TransactionCode
	 **/
	static public function FamilyAllowance() {
		return new self(self::FamilyAllowance);
	}

	/**
	 * Pay transaction
	 *
	 * @return TransactionCode
	 **/
	static public function Pay() {
		return new self(self::Pay);
	}

	/**
	 * Pension transaction
	 *
	 * @return TransactionCode
	 **/
	static public function Pension() {
		return new self(self::Pension);
	}

	/**
	 * Allotment transaction
	 *
	 * @return TransactionCode
	 **/
	static public function Allotment() {
		return new self(self::Allotment);
	}

	/**
	 * Dividend transaction
	 *
	 * @return TransactionCode
	 **/
	static public function Dividend() {
		return new self(self::Dividend);
	}

	/**
	 * Debenture transaction
	 *
	 * @return TransactionCode
	 **/
	static public function Debenture() {
		return new self(self::Debenture);
	}
}
