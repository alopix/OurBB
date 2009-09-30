<?php
/**
 * OurBB, a small but effective Burning Board
 *
 * Copyright (C) 2009 Dustin Steiner
 *
 * This work is licensed under the Creative Commons Attribution-Share Alike 3.0 Austria License.
 * To view a copy of this license, visit http://creativecommons.org/licenses/by-sa/3.0/at/ or send a letter to
 *  Creative Commons, 171 Second Street, Suite 300, San Francisco, California, 94105, USA.
 */

/**
 * the Database Abstraction Layer
 */
abstract class dbal
{
	/**
	 * holds the connection to the database
	 * @access protected
	 * @var resource
	 */
	protected $connectionLink = NULL;
	
	/**
	 * the counter for the sql-query
	 * @access private
	 * @var integer
	 */
	private $queryCount = 0;
}

/**
* This variable holds the class name to use later
*/
$sqlDbms = (!empty($dbms) ? strtolower($dbms) : 'dbal');
?>