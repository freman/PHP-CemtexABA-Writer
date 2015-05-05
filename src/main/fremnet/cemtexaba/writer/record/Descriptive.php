<?php namespace fremnet\cemtexaba\writer\record;

use DateTime;
use fremnet\cemtexaba\writer\Record;

/**
 * Cemtext ABA Descriptive (header) record
 *
 * @version 1.0.0
 * @author Shannon Wynter (http://fremnet.net/contact)
 * @copyright Copyright (c) 2014, Shannon Wynter (Fremnet)
 * @license http://www.gnu.org/licenses/gpl-2.0.html GPL 2.0 or greater
 * @package Fremnet
 * @subpackage CemtextABA
 */
class Descriptive extends Record {
	/** @var int 1 - 99 */
	protected $reel_sequence_number         = 1;

	/** @var string Approved financial insitution abbreviation */
	protected $financial_institution        = '';

	/** @var string Left justified, blank filled. All coded character set valid. Must not be all blanks. */
	protected $user_preferred_specification = '';

	/** @var int 0-999999 */
	protected $user_identification_number   = 0;

	/** @var string Description of entries in file */
	protected $description_of_file          = '';

	/** @var DateTime Date to be processed */
	protected $date_to_process;

	/**
	 * Constructor
	 *
	 * Set the date_to_process with guess_date_to_process if none passed
	 *
	 * @param  array $args
	 */
	public function __construct(array $args = []) {
		parent::__construct($args);
		if (!isset($this->date_to_process)) {
			$this->guess_date_to_process();
		}
	}

	/**
	 * Set the reel sequence number
	 *
	 * @throws OutOfRangeExcetion
	 * @param  int $reel_sequence_number a number between 1 and 99
	 * @return Descriptive
	 */
	public function set_reel_sequence_number($reel_sequence_number) {
		if ($reel_sequence_number < 1 || $reel_sequence_number > 99)
			throw new OutOfRangeException('1 <> 99');

		$this->reel_sequence_number = $reel_sequence_number;
		return $this;
	}

	/**
	 * Set financial institution
	 *
	 * @throws LengthException
	 * @param  string $financial_institution
	 * @return Descriptive
	 */
	public function set_financial_institution($financial_institution) {
		if (strlen($financial_institution) > 3)
			throw new LengthException('Must be 3 characters, eg BQL, WBC');
		$this->financial_institution = $financial_institution;
		return $this;
	}

	/**
	 * Set user preferred specification
	 *
	 * As adviced by the user's financial insttution
	 *
	 * @param  string $user_preferred_specification
	 * @return Descriptive
	 */
	public function set_user_preferred_specification($user_preferred_specification) {
		if (strlen(trim($user_preferred_specification)) == 0)
			throw new LengthException('Must be set to a non-blank value');

		$this->user_preferred_specification = $user_preferred_specification;
		return $this;
	}

	/**
	 * Set user identification number
	 *
	 * Must be the user identification number which is allocated by APCA
	 *
	 * @throws OutOfRangeException
	 * @param  int $user_identification_number
	 * @return Descriptive
	 */
	public function set_user_identification_number($user_identification_number) {
		if ($user_identification_number < 0 || $user_identification_number > 999999)
			throw new OutOfRangeException('1 <> 999999');

		$this->user_identification_number = $user_identification_number;
		return $this;
	}

	/**
	 * Set the description of the file
	 *
	 * Description of entries on file e.g. "PAYROLL"
	 *
	 * @param  string $description_of_file
	 * @return Descriptive
	 */
	public function set_description_of_file($description_of_file) {
		if (strlen(trim($description_of_file)) == 0)
			throw new LengthException('Must be set to a non-blank value');

		$this->description_of_file = $description_of_file;
		return $this;
	}

	/**
	 * Set the date to process
	 *
	 * At this date the transactions are released to all financial institutions
	 * Is usually a business day
	 *
	 * @param  DateTime $date_to_process
	 * @return Descriptive
	 */
	public function set_date_to_process(DateTime $date_to_process) {
		$this->date_to_process = $date_to_process;
		return $this;
	}

	/**
	 * Get the stored reel sequence number
	 *
	 * @return int
	 */
	public function get_reel_sequence_number() {
		return $this->reel_sequence_number;
	}

	/**
	 * Get the stored financial institution
	 *
	 * @return string
	 */
	public function get_financial_institution($financial_institution) {
		return $this->financial_institution;
	}

	/**
	 * Get the stored user preferred specification
	 *
	 * @return string
	 */
	public function get_user_preferred_specification($user_preferred_specification) {
		return $this->user_preferred_specification;
	}

	/**
	 * Get the stored user identification number
	 *
	 * @return int
	 */
	public function get_user_identification_number($user_identification_number) {
		return $this->user_identification_number;
	}

	/**
	 * Get the stored description of file
	 *
	 * @return string
	 */
	public function get_description_of_file($description_of_file) {
		return $this->description_of_file;
	}

	/**
	 * Get the stored date to process
	 *
	 * @return DateTime
	 */
	public function get_date_to_process(DateTime $date_to_process) {
		return $this->date_to_process;
	}

	/**
	 * Increment the reel sequence number
	 *
	 * Wraps at 99 back to 1
	 *
	 * @return Descriptive
	 */
	public function inc_reel_sequence_number() {
		$this->reel_sequence_number ++;
		if ($this->reel_sequence_number > 99)
			$this->reel_sequence_number = 1;

		return $this;
	}

	/**
	 * Guess date to process
	 *
	 * Given no other information than the current timestamp
	 * work out the best date to set as the date to process
	 *
	 * - If after 5 pm, then set it to tomorrow.
	 * - If not a week day make it Monday.
	 *
	 * @return Descriptive
	 */
	public function guess_date_to_process() {
		$time = new DateTime();

		// If after 5, move to next day
		if ($time->format('H') > 17)
			$time->add(new DateInterval('P1D'));

		$time->setTime(0,0,0);

		// If not mon-fri, move to next week day
		if (($day = $time->format('N')) > 5)
			$time->add(new DateInterval('P' . (7 - $day) . 'D'));

		$this->date_to_process = $time;

		return $this;
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
		if (strlen($this->financial_institution) != 3)
			throw new LengthException('Must be 3 characters, eg BQL, WBC');

		if (strlen(trim($this->user_preferred_specification)) == 0)
			throw new LengthException('Must be set to a non-blank value');

		if (strlen(trim($this->description_of_file)) == 0)
			throw new LengthException('Must be set to a non-blank value');

		return sprintf('0%17s%02d%-3s%7s%-26s%06d%-12s%06d%40s',
			'',
			$this->reel_sequence_number % 100,
			strtoupper($this->financial_institution),
			'',
			strtoupper(substr($this->user_preferred_specification, 0, 26)),
			$this->user_identification_number % 1000000,
			strtoupper(substr($this->description_of_file, 0, 12)),
			$this->date_to_process->format('dmy'),
			''
		);
	}
};
