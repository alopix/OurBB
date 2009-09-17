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
 * the extended Exception for MySQL
 */
class MySQLException extends Exception
{
	/**
	 * define a MySQL-specific string for the exception
	 * @return string
	 */
	public function __toString()
	{
		return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
	}
}


/**
 * this class handles the MySQL-connection
 */
class MySQL
{
	/**
	 * holds the connection to the database
	 * @access protected
	 * @var resource
	 */
	protected $connectionLink = NULL;
	
	/**
	 * the counter for the mysql-query
	 * @access private
	 * @var integer
	 */
	private $queryCount = 0;
	
	/**
	 * creates a link to the MySQL-Database
	 * @param string $sqlHost the hostname of the mysql-server
	 * @param string $sqlUser the username to log into your database
	 * @param string $sqlPassword the password to log into your database
	 * @param string $sqlDBthe database where to find the OurBB-tables
	 */
	public function __construct($sqlHost, $sqlUser, $sqlPassword, $sqlDB)
	{
		try {
			$this->connectionLink = mysql_connect($sqlHost, $sqlUser, $sqlPassword);
			if (!$this->connectionLink) {
				throw new MySQLException(mysql_error($this->connectionLink), mysql_errno($this->connectionLink)); // Could not create a connection to the MySQL
			}
			
			$database = mysql_select_db($sqlDB, $this->connectionLink);
			if (!$database) {
				throw new MySQLException(mysql_error($this->connectionLink), mysql_errno($this->connectionLink)); // Could not select MySQL-database
			}
		} catch (MySQLException $e) {
			echo $e;
		}
	}
	
	/**
	 * destroy the open database-connection
	 */
	private function __destruct() 
	{
		try {
			$this->connectionLink = mysql_close($this->connectionLink);
			if ($this->connectionLink) {
				throw new MySQLException(mysql_error($this->connectionLink), mysql_errno($this->connectionLink)); // Could not close connection to MySQL
			}
		} catch (MySQLException $e) {
			echo $e;
		}
	}
	
	/**
	 * send a query to the database
	 * @param string|integer $...
	 * @return resource
	 */
	public function query()
	{
		$arguments = func_get_args();
		$query = array_shift($arguments);
		$arguments = array_map(array($this, 'realEscapeString'), $arguments);
		$query  = vsprintf($query, $arguments);
		try {
			$result = mysql_query($query, $this->connectionLink);
			if (!$result) {
				throw new MySQLException(mysql_error($this->connectionLink), mysql_errno($this->connectionLink)); // Could not send query
			}
		} catch (MySQLException $e) {
			echo $e;
		}
		
		$this->queryCount++;
		return $result;
	}
	
	/**
	 * real escapes the MySQL-user-inputs
	 * @param string $input the user-input
	 * @return string
	 */
	public function realEscapeString($input)
	{
		if (get_magic_quotes_gpc()) {
			$input = stripslashes($input);
		}
		$input = mysql_real_escape_string($input, $this->connectionLink);
		
		return $input;
	}
	
	/**
	 * return the MySQL-result-data as an assoc array
	 * @param resource $result the MySQL-result of the query
	 * @return array
	 */
	public function fetchArray($result)
	{
		return mysql_fetch_array($result);
	}
	
	/**
	 * return the MySQL-result-data as an assoc array
	 * @param resource $result the MySQL-result of the query
	 * @return array
	 */
	public function fetchAssoc($result)
	{
		return mysql_fetch_assoc($result);
	}
	
	/**
	 * return the MySQL-result-data as an numbered-array
	 * @param resource $result the MySQL-result of the query
	 * @return array
	 */
	public function fetchRow($result)
	{
		return mysql_fetch_row($result);
	}
	
	/**
	 * return the number of the fetched MySQL-results
	 * @param resource|string $result the MySQL-result of the query or the query itself
	 * @param boolean $isQuery tell the function if the given result is a query or not
	 * @return integer
	 */
	public function numRows($result, $isQuery = false)
	{
		if ($isQuery === true) {
			$result = $this->query($result);
		}
		
		$count = mysql_num_rows($result);
		return $count;
	}
	
	/**
	 * frees the result of a MySQL-query
	 * @param resource $result the MySQL-result of the query
	 * @return boolean
	 */
	public function freeResult($result)
	{
		return mysql_free_result($result);
	}
	
	/**
	 * the number of affected rows by the MySQL-query
	 * @return integer
	 */
	public function affectedRows()
	{
		return mysql_affected_rows($this->connectionLink);
	}
 
	/**
	 * get the ID generated from the previous INSERT operation
	 * @return integer
	 */
	public function insertId()
	{
		return mysql_insert_id($this->connectionLink);
	}
	
	/**
	 * return the number of querys send so far
	 * @return integer
	 */
	public function getQueryCount() {
		return $this->queryCount;
	}
}
?>
