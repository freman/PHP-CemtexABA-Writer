<?php namespace fremnet\cemtexaba\writer;

/**
 * Cemtext ABA Base Record
 *
 * Implements lazy constructor arguments
 *
 * @version 1.0.0
 * @author Shannon Wynter (http://fremnet.net/contact)
 * @copyright Copyright (c) 2014, Shannon Wynter (Fremnet)
 * @license http://www.gnu.org/licenses/gpl-2.0.html GPL 2.0 or greater
 * @package Fremnet
 * @subpackage CemtextABA
 */
abstract class Record {
	/**
	 * Constructor
	 *
	 * @throws InvalidArgumentException
	 * @param array $args a named array of fields to set
	 */
	public function __construct(array $args = []) {
		foreach ($args as $name => $value) {
			if (method_exists($this, "set_$name")) {
				call_user_func([$this, "set_$name"], $value);
			}
			else {
				throw new InvalidArgumentException("Property $name does not exist");
			}
		}
	}
}
