<?php
class Sql {
	//0 if not affected or no AI column
	private $lastId = 0;
	//0 if none affected
	private $numAffectedRows = 0;
	//false on failure, object on select, true otherwise
	private $result = false;
	
	private $sql;

	public function Sql($sql, array $params=array()) {
		$dbConn = self::getDbConn();
		foreach ($params as $key => $param)
			$params[$key] = $dbConn->escape_string($param);
		$dbConn->close();
		
		array_unshift($params, $sql);
		$this->sql = call_user_func_array("sprintf", $params);
		
		self::log($this->sql);
	}
	
	public static function log($text) {
		$file = RESOURCES_PATH . "/log.txt";
		$fh = fopen($file, 'a') or die("can't open file");
		fwrite($fh, $text . "\n");
		fclose($fh);
	}

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