<?php namespace fremnet\cemtexaba;
/**
 * Cemtext ABA Writer - PHP5 method of writing those ABA files
 * Copyright (C) 2014 Shannon Wynter
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 *
 * Changelog
 * ------------
 * version 1.0, 2014-03-20, Shannon Wynter {@link http://fremnet.net/contact}
 * - initial release
 *
 * @version 1.0
 * @author Shannon Wynter {@link http://fremnet.net/contact}
 * @copyright Copyright &copy; 2014 Shannon Wynter (Fremnet)
 * @license http://www.gnu.org/licenses/gpl-2.0.html GPL 2.0 or greater
 * @package Fremnet
 * @subpackage CemtexABA
 */

use fremnet\cemtexaba\writer\Details;
use fremnet\cemtexaba\writer\record\Descriptive;
use fremnet\cemtexaba\writer\record\Detail;
use fremnet\cemtexaba\writer\record\Total;

/**
 * Cemtext ABA Writer
 *
 * @version 1.0.0
 * @author Shannon Wynter (http://fremnet.net/contact)
 * @copyright Copyright (c) 2014, Shannon Wynter (Fremnet)
 * @license http://www.gnu.org/licenses/gpl-2.0.html GPL 2.0 or greater
 * @package Fremnet
 * @subpackage CemtextABA
 */
class Writer {
	/** @var Descriptive */
	protected $header;

	/** @var Details */
	protected $details;

	/** @var Total */
	protected $total;

	/**
	 * Constructor
	 *
	 * Does the usual things a constructor does
	 */
	public function __construct() {
		$this->clear_details();
	}

	/**
	 * Set the header record
	 *
	 * @param  Descriptive $header The descriptive object to use for a header
	 * @return Writer $this
	 */
	public function set_header(Descriptive $header) {
		$this->header = $header;
		return $this;
	}

	/**
	 * Set the total record
	 *
	 * @param Total $total The file total record
	 * @return Writer $this
	 */
	public function set_total(Total $total) {
		$this->total = $total;
		return $this;
	}

	/**
	 * Get the hreader record
	 *
	 * @return Descriptive The stored header record
	 */
	public function get_header() {
		return $this->header;
	}

	/**
	 * Add a detail record
	 *
	 * @param  Detail $detail
	 * @return Writer $this
	 */
	public function add_detail(Detail $detail) {
		$this->details[] = $detail;
		return $this;
	}

	/**
	 * Clear the stored details
	 *
	 * @return Writer $this
	 */
	public function clear_details() {
		$this->details = new Details();
		return $this;
	}

	/**
	 * Return the list of stored details
	 *
	 * @return Details
	 */
	public function get_details() {
		return $this->details;
	}

	/**
	 * Generate the total record for this file
	 *
	 * @return Writer $this
	 */
	public function generate_total() {
		$this->total = $this->details->generate_total_record();
		return $this;
	}

	/**
	 * Get stored total
	 *
	 * @return Total
	 */
	public function get_total() {
		return $this->total;
	}

	/**
	 * Result as a string
	 *
	 * @return string
	 */
	public function result() {
		return (string) $this;
	}

	/**
	 * Output as a string
	 *
	 * @return string
	 */
	public function output() {
		echo (string) $this;
	}

	/**
	 * Download
	 *
	 * @param  string $filename optional filename
	 */
	public function download($filename = null) {
		header('Content-type: application/aba');
		if ($filename !== null)
			header("Content-Disposition: attachment; filename=\"$filename\"");

		echo (string) $this;
	}

	/**
	 * Save to a file
	 *
	 * @param  string $filename
	 */
	public function save($filename) {
		file_put_contents($filename, (string) $this);
	}

	/**
	 * Magic string method
	 *
	 * Converts the stored information to a properly formatted file
	 *
	 * @throws LogicException
	 * @return string
	 */
	public function __toString() {
		if (!$this->header)
			throw new LogicException('No header');

		$this->generate_total();

		$data = $this->details->get_array();
		array_unshift($data, $this->header);
		array_push($data, $this->total);

		return join("\r\n", $data);
	}
}
