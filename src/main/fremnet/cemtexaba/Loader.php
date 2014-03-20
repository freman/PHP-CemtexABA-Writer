<?php
/**
 * Cemtext ABA Loader
 *
 * Loads all the required classes in case you're not using an autoloader
 *
 * @version 1.0.0
 * @author Shannon Wynter (http://fremnet.net/contact)
 * @copyright Copyright (c) 2014, Shannon Wynter (Fremnet)
 * @license http://www.gnu.org/licenses/gpl-2.0.html GPL 2.0 or greater
 * @package Fremnet
 * @subpackage CemtextABA
 */
include_once('writer/Record.php');
include_once('writer/record/detail/TransactionCode.php');
include_once('writer/record/detail/Indicator.php');
include_once('writer/record/Descriptive.php');
include_once('writer/record/Detail.php');
include_once('writer/record/Total.php');
include_once('writer/Details.php');
include_once('Writer.php');
