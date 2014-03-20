<?php namespace fremnet\cemtexaba\writer;

use Iterator;
use Countable;
use ArrayAccess;
use fremnet\cemtexaba\writer\record\Detail;
use fremnet\cemtexaba\writer\record\Total;

/**
 * Cemtext ABA Details Module
 *
 * Keeps track of the transactions adding up credits and debits as it goes
 *
 * @version 1.0.0
 * @author Shannon Wynter (http://fremnet.net/contact)
 * @copyright Copyright (c) 2014, Shannon Wynter (Fremnet)
 * @license http://www.gnu.org/licenses/gpl-2.0.html GPL 2.0 or greater
 * @package Fremnet
 * @subpackage CemtextABA
 */
class Details implements Iterator, Countable, ArrayAccess {
	/** @var [Detail] **/
	protected $entries = [];

	/** @var int Total value of credits in cents **/
	protected $credits = 0;

	/** @var int Total value of debits in cents **/
	protected $debits  = 0;

	/**
	 * Generate a Total record
	 *
	 * @return Total
	 */
	public function generate_total_record() {
		return new Total([
			'net_total_amount'    => abs($this->credits - $this->debits),
			'credit_total_amount' => $this->credits,
			'debit_total_amount'  => $this->debits,
			'record_count'        => count($this->entries)
		]);
	}

	/**
	 * Get the entries list as an array
	 *
	 * Because it makes life easier
	 *
	 * @return [Detail]
	 */
	public function get_array() {
		return $this->entries;
	}

	/**
	 * Perform the math on new entry
	 *
	 * @param  Detail $value
	 */
	protected function add (Detail $value) {
		if ($value->is_credit()) {
			$this->credits += $value->get_amount();
		}
		else {
			$this->debits += $value->get_amount();
		}
	}

	/**
	 * Perform the math on a removed entry
	 *
	 * @param  Detail $value
	 */
	protected function subtract (Detail $value) {
		if ($value->is_credit()) {
			$this->credits -= $value->get_amount();
		}
		else {
			$this->debits -= $value->get_amount();
		}
	}

	/**
	 * Offset to set
	 *
	 * @see    http://php.net/ArrayAccess
	 * @param  mixed $offset
	 * @param  mixed $value (Should be Detail)
	 */
	public function offsetSet($offset, $value) {
		$this->add($value);

		if ($offset === null) {
			$this->entries[] = $value;
		}
		else {
			$this->entries[$offset] = $value;
		}
	}

	/**
	 * Check if offset exists
	 *
	 * @see    http://php.net/ArrayAccess
	 * @param  mixed $offset
	 */
	public function offsetExists($offset) {
		return isset($this->entries[$offset]);
	}

	/**
	 * Unset an offset
	 *
	 * @see    http://php.net/ArrayAccess
	 * @param  mixed $offset
	 */
	public function offsetUnset($offset) {
		$this->subtract($this->entries[$offset]);

		unset($this->entries[$offset]);
	}

	/**
	 * Get the value at an offset
	 *
	 * @see    http://php.net/ArrayAccess
	 * @return Detail
	 */
	public function offsetGet($offset) {
		return isset($this->entries[$offset]) ? $this->entries[$offset] : null;
	}

	/**
	 * Rewind the iterator to the first element
	 *
	 * @see    http://php.net/Iterator
	 */
	public function rewind() {
		reset($this->entries);
	}

	/**
	 * Return the current element
	 *
	 * @see    http://php.net/Iterator
	 * @return Detail
	 */
	public function current() {
		return current($this->entries);
	}

	/**
	 * Return the key of the current element
	 *
	 * @see    http://php.net/Iterator
	 * @return mixed
	 */
	public function key() {
		return key($this->entries);
	}

	/**
	 * Move forward to next element
	 *
	 * @see    http://php.net/Iterator
	 */
	public function next() {
		next($this->entries);
	}


	/**
	 *  Checks if current position is valid
	 *
	 * @see    http://php.net/Iterator
	 * @return boolean
	 */
	public function valid() {
		$key = key($this->entries);
		return ($key !== null && $key !== false);
	}

	/**
	 * Count elements of an object
	 *
	 * @see    http://php.net/Countable
	 * @return int
	 */
	public function count() {
		return count($this->entries);
	}
}
