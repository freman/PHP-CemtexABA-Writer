<?php namespace fremnet\cemtexaba\writer\record;

use InvalidArgumentException;
use fremnet\cemtexaba\writer\Record;
use fremnet\cemtexaba\writer\record\detail\Indicator;
use fremnet\cemtexaba\writer\record\detail\TransactionCode;

/**
 * Cemtext ABA Detail (item) record
 *
 * @version 1.0.0
 * @author Shannon Wynter (http://fremnet.net/contact)
 * @copyright Copyright (c) 2014, Shannon Wynter (Fremnet)
 * @license http://www.gnu.org/licenses/gpl-2.0.html GPL 2.0 or greater
 * @package Fremnet
 * @subpackage CemtextABA
 */
class Detail extends Record {
	/** @var string xxxxxx or xxx-xxx **/
	protected $bsb;

	/** @var string **/
	protected $account_number;

	/** @var Indicator **/
	protected $indicator;

	/** @var TransactionCode **/
	protected $transaction_code;

	/** @var int Cents **/
	protected $amount;

	/** @var string **/
	protected $title_of_account;

	/** @var string **/
	protected $lodgement_reference;

	/** @var string xxxxxx or xxx-xxx **/
	protected $trace_record_bsb;

	/** @var string **/
	protected $trace_record_account_number;

	/** @var string **/
	protected $name_of_remitter;

	/** @var int Cents **/
	protected $amount_of_withholding_tax;

	/**
	 * Set the BSB
	 *
	 * @throws InvalidArgumentException
	 * @param  string $bsb 123456 or 123-456
	 * @return Detail
	 */
	public function set_bsb($bsb) {
		if (!preg_match('/^\d{3}-?\d{3}$/', $bsb))
			throw new InvalidArgumentException('xxxxxx or xxx-xxx');

		$this->bsb = $bsb;
		return $this;
	}

	/**
	 * Set the account number to be credited/debited
	 *
	 * Numeric, hyphens and blanks only are valid. Must not contain all
	 * blanks or be void (unless a credit card transaction) or zeros.
	 * Leading zeros which are part of a valid account number must be
	 * included, e.g. 00-1234.
	 *
	 * @throws InvalidArgumentException
	 * @param  string $account_number
	 * @return Detail
	 */
	public function set_account_number($account_number) {
		if (!preg_match('/^[\d- ]+$/', $account_number))
			throw new InvalidArgumentException('Only blanks, hyphens, and numeric supported');

		$this->account_number = $account_number;
		return $this;
	}

	/**
	 * Set the Indicator
	 *
	 * @param  Indicator $indicator 1 character
	 * @return Detail
	 */
	public function set_indicator(Indicator $indicator) {
		$this->indicator = $indicator;
		return $this;
	}

	/**
	 * Set the transaction code
	 *
	 * @param  TransactionCode $transaction_code
	 * @return Detail
	 */
	public function set_transaction_code(TransactionCode$transaction_code) {
		$this->transaction_code = $transaction_code;
		return $this;
	}

	/**
	 * Set the amount to credit/debit in cents
	 *
	 * @throws InvalidArgumentException
	 * @param  int $amount
	 * @return Detail
	 */
	public function set_amount($amount) {
		if (!preg_match('/^\d+$/', $amount))
			throw new InvalidArgumentException('Cents only');

			$this->amount = $amount;
		return $this;
	}

	/**
	 * Set the title of the account
	 *
	 * Desirable Format for Transaction Account credits:
	 * - Surname (period)
	 * - Space
	 * - Given name with spaces between each name
	 *
	 * @throws InvalidArgumentException
	 * @param  string $title_of_account
	 * @return Detail
	 */
	public function set_title_of_account($title_of_account) {
		if (!preg_match('/^.+$/', $title_of_account))
			throw new InvalidArgumentException('Must not be blank');

			$this->title_of_account = $title_of_account;
		return $this;
	}

	/**
	 * Set the lodgement reference
	 *
	 * Field must be left justified, and contain only the 16
	 * character Employee Benefits Card number; for example
	 * 5550033890123456 or be blank
	 *
	 * @throws InvalidArgumentException
	 * @param  string $lodgement_reference
	 * @return Detail
	 */
	public function set_lodgement_reference($lodgement_reference) {
		$this->lodgement_reference = $lodgement_reference;
		return $this;
	}

	/**
	 * Set the trace record BSB
	 *
	 * Bank (FI)/State/Branch of user to enable retracing of the entry to
	 * its source if necessary. Only numeric and hyphens valid.
	 *
	 * @param  string $trace_record_bsb  123456 or 123-456
	 * @return Detail
	 */
	public function set_trace_record_bsb($trace_record_bsb) {
		if (!preg_match('/^\d{3}-?\d{3}$/', $trace_record_bsb))
			throw new InvalidArgumentException('xxxxxx or xxx-xxx');

		$this->trace_record_bsb = $trace_record_bsb;
		return $this;
	}

	/**
	 * Set the trace record account number
	 *
	 * Account number of user to enable retracing of the entry to
	 * its source if necessary. Only numeric and hyphens valid.
	 *
	 * @param  string $trace_record_account_number
	 * @return Detail
	 */
	 	public function set_trace_record_account_number($trace_record_account_number) {
		if (!preg_match('/^[\d- ]+$/', $trace_record_account_number))
			throw new InvalidArgumentException('Only blanks, hyphens, and numeric supported');

			$this->trace_record_account_number = $trace_record_account_number;
		return $this;
	}

	/**
	 * Set the name of the remitter
	 *
	 * Name of originator of the entry. This may vary from Name of
	 * the user.
	 *
	 * Must not be empty.
	 *
	 * @param  string $name_of_remitter
	 * @return Detail
	 */
	public function set_name_of_remitter($name_of_remitter) {
		if (!preg_match('/.+/', $name_of_remitter))
			throw new InvalidArgumentException('Cannot be empty');

		$this->name_of_remitter = $name_of_remitter;
		return $this;
	}

	/**
	 * Set the amount of witholding tax in cents
	 *
	 * @param  int $amount_of_withholding_tax
	 * @return Detail
	 */
	public function set_amount_of_withholding_tax($amount_of_withholding_tax) {
		$this->amount_of_withholding_tax = $amount_of_withholding_tax;
		return $this;
	}

	/**
	 * Get the stored BSB
	 *
	 * @return string
	 */
	public function get_bsb() {
		return $this->bsb;
	}

	/**
	 * Get the stored account number
	 *
	 * @return string
	 */
	public function get_account_number() {
		return $this->account_number;
	}

	/**
	 * Get the stored indicator
	 *
	 * @return string
	 */
	public function get_indicator() {
		return $this->indicator;
	}

	/**
	 * Get the stored transaction code
	 *
	 * @return string
	 */
	public function get_transaction_code() {
		return $this->transaction_code;
	}

	/**
	 * Get the stored aount in cents
	 *
	 * @return int
	 */
	public function get_amount() {
		return $this->amount;
	}

	/**
	 * Get the stored title of the account
	 *
	 * @return string
	 */
	public function get_title_of_account() {
		return $this->title_of_account;
	}

	/**
	 * Get the stored lodgeent reference
	 *
	 * @return string
	 */
	public function get_lodgement_reference() {
		return $this->lodgement_reference;
	}

	/**
	 * Get the stored trace record bsb
	 *
	 * @return string
	 */
	public function get_trace_record_bsb() {
		return $this->trace_record_bsb;
	}

	/**
	 * Get the stored trace record account number
	 *
	 * @return string
	 */
	public function get_trace_record_account_number() {
		return $this->trace_record_account_number;
	}

	/**
	 * Get the stored name of remitter
	 *
	 * @return string
	 */
	public function get_name_of_remitter() {
		return $this->name_of_remitter;
	}

	/**
	 * Get the stored amount of witholding tax in cents
	 *
	 * @return string
	 */
	public function get_amount_of_withholding_tax() {
		return $this->amount_of_withholding_tax;
	}

	/**
	 * Is this transaction a credit
	 *
	 * @return boolean
	 */
	public function is_credit() {
		return $this->transaction_code->is_credit();
	}

	/**
	 * Is this transaction a debit
	 *
	 * @return boolean
	 */
	public function is_debit() {
		return $this->transaction_code->is_debit();
	}

	/**
	 * Format an account number
	 *
	 * Formats account numbers stripping -'s if needed
	 *
	 * @param  string $account_number
	 * @return string
	 */
	private function format_account_number($account_number) {
		$account_number = trim($account_number);
		if (strlen($account_number) > 9) {
			$account_number = strreplace('-', '', $accoutn_number);
		}
		return $account_number;
	}

	/**
	 * Magic string method
	 *
	 * Converts the stored information to a properly formatted record
	 *
	 * @throws InvalidArgumentException
	 * @return string
	 */
	public function __toString() {
		// Revalidate all the data in case the class has been extended
		if (!preg_match('/^\d{3}-?\d{3}$/', $this->bsb))
			throw new InvalidArgumentException('xxxxxx or xxx-xxx');

		if (!preg_match('/^[\d- ]+$/', $this->account_number))
			throw new InvalidArgumentException('Only blanks, hyphens, and numeric supported');

		if (!preg_match('/^\d+$/', $this->amount))
			throw new InvalidArgumentException('Cents only');

		if (!preg_match('/^\d{3}-?\d{3}$/', $this->trace_record_bsb))
			throw new InvalidArgumentException('xxxxxx or xxx-xxx');

		if (!preg_match('/^[\d- ]+$/', $this->trace_record_account_number))
			throw new InvalidArgumentException('Only blanks, hyphens, and numeric supported');

		if (!preg_match('/.+/', $this->name_of_remitter))
			throw new InvalidArgumentException('Cannot be empty');

		return sprintf('1%7s%9s%1s%02d%010d%-32s%-18s%7s%9s%-16s%08d',
			preg_replace('/(\d{3})-?(\d{3})/', '$1-$2', $this->bsb),
			$this->format_account_number($this->account_number),
			(string)$this->indicator,
			(string)$this->transaction_code,
			$this->amount,
			substr($this->title_of_account, 0, 32),
			substr(trim($this->lodgement_reference), 0, 18),
			preg_replace('/(\d{3})-?(\d{3})/', '$1-$2', $this->trace_record_bsb),
			trim($this->trace_record_account_number),
			substr($this->name_of_remitter, 0, 16),
			$this->amount_of_withholding_tax
		);
	}
};
