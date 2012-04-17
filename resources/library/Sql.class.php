<?php
/**
 * Class to handle all SQL interaction
 * Automatically escapes and logs all actions
 * @author lecturate
 *
 */
class Sql {
	/**
	 * 0 if not affected or no AI column
	 * @var int
	 */
	private $lastId = 0;
	
	/**
	 * 
	 */
	/**
	 * 0 if none affected
	 * @var int
	 */
	private $numAffectedRows = 0;
	
	
	/**
	 * false on failure, object on select, true otherwise
	 * @var boolean
	 */
	private $result = false;
	
	/**
	 * sql statement
	 * @var string
	 */
	private $sql;

	/**
	 * prepare an SQL statement, do not yet execute
	 * @param string $sql SQL statement with %d, %s placeholders for variables that should bei incorporated
	 * @param array $params values that placeholders should be replaced with
	 */
	public function Sql($sql, array $params=array()) {
		$dbConn = self::getDbConn();
		foreach ($params as $key => $param)
			$params[$key] = $dbConn->escape_string($param);
		$dbConn->close();
		
		array_unshift($params, $sql);
		$this->sql = call_user_func_array("sprintf", $params);
		
		self::log($this->sql);
	}
	
	/**
	 * write statement to log
	 * @param string $text
	 */
	public static function log($text) {
		$text = date('m.d.Y H:i:s') . ": $text\n";
		$text .= file_get_contents(SQLLOG);
		file_put_contents(SQLLOG, $text);
	}

	/**
	 * execute the prepared SQL statement
	 */
	public function exec() {
		$dbConn = self::getDbConn();
		$this->result = $dbConn->query($this->sql);		
		
		$this->numAffectedRows = $dbConn->affected_rows;
		$this->lastId = $dbConn->insert_id;
		
		$dbConn->close();
	}

	public function getLastId() {
		return $this->lastId;
	}

	public function getNumAffectedRows() {
		return $this->numAffectedRows;
	}

	public function getResult() {
		return $this->result;
	}

	/**
	 * get a DB connection, should not be necessary to use in most cases, as exec() does this automaticlly
	 * @throws Exception
	 */
	public static function getDbConn() {
		global $config;
		$dbConn = new mysqli($config["db"]["host"], $config["db"]["username"], $config["db"]["password"]);

		if (mysqli_connect_errno()) {
			throw new Exception("Connect failed}");
			die();
		}

		$dbConn->select_db($config["db"]["dbname"]);

		return $dbConn;
	}
	
	/**
	 * convenience method that automatically executes the SQL statement after preparing it
	 * @param unknown_type $sql
	 * @param array $params
	 */
	public static function execute($sql, array $params = array()) {
		$obj = new Sql($sql, $params);
		$obj->exec();
		return $obj;
	}
	
	public function getSql() {
		return $this->sql;
	}

}
?>