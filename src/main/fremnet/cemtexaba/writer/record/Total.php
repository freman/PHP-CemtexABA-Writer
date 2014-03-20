<?php namespace fremnet\cemtexaba\writer\record;

use fremnet\cemtexaba\writer\Record;

/**
 * Cemtext ABA Total record
 *
 * @version 1.0.0
 * @author Shannon Wynter (http://fremnet.net/contact)
 * @copyright Copyright (c) 2014, Shannon Wynter (Fremnet)
 * @license http://www.gnu.org/licenses/gpl-2.0.html GPL 2.0 or greater
 * @package Fremnet
 * @subpackage CemtextABA
 */
class Total extends Record {
	/** @var int credit - debit or debit - credit in cents **/
	protected $net_total_amount;

	/** @var int credit total in cents **/
	protected $credit_total_amount;

	/** @var int debit total in cents **/
	protected $debit_total_amount;

	/** @var int record count **/
	protected $record_count;

	/**
	 * Set Net Total Amount
	 *
	 * @param  int $net_total_amount in cents
	 * @return Total
	 */
	public function set_net_total_amount($net_total_amount) {
		$this->net_total_amount = $net_total_amount;
		return $this;
	}

	/**
	 * Set Credit Total Amount
	 *
	 * @param  int $credit_total_amount in cents
	 * @return Total
	 */
	public function set_credit_total_amount($credit_total_amount) {
		$this->credit_total_amount = $credit_total_amount;
		return $this;
	}

	/**
	 * Set Debit Total Amount
	 *
	 * @param  int $debit_total_amount in cents
	 * @return Total
	 */
	public function set_debit_total_amount($debit_total_amount) {
		$this->debit_total_amount = $debit_total_amount;
		return $this;
	}

	/**
	 * Set the total record count
	 *
	 * @param  int $record_count
	 * @return Total
	 */
	public function set_record_count($record_count) {
		$this->record_count = $record_count;
		return $this;
	}

	/**
	 * Get Net Total Amount
	 *
	 * @return int cents
	 */
	public function get_net_total_amount($net_total_amount) {
		return $this->net_total_amount;
	}

	/**
	 * Get Credit Total Amount
	 *
	 * @return int cents
	 */
	public function get_credit_total_amount($credit_total_amount) {
		return $this->credit_total_amount;
	}

	/**
	 * Get Debit Total Amount
	 *
	 * @return int cents
	 */
	public function get_debit_total_amount($debit_total_amount) {
		return $this->debit_total_amount;
	}

	/**
	 * Get the total record count
	 *
	 * @return int
	 */
	public function get_record_count() {
		return $this->record_count;
	}

	/**
	 * Magic string method
	 *
	 * Converts the stored information to a properly formatted record
	 *
	 * @throws LengthException
	 * @return string
	 */
	public function __toString() {
		return sprintf('7999-999%12s%010d%010d%010d%24s%06d%50s',
			'',
			$this->net_total_amount,
			$this->credit_total_amount,
			$this->debit_total_amount,
			'',
			$this->record_count,
			''
		);
	}
};
