<?php
require_once(realpath(dirname(__FILE__) . "/../config.php"));

function result($query, $paramTypes) {
	$results = array();
	$dbConn = getDbConn();

	if ($stmt = $dbConn->prepare($query)) {
		if (func_num_args() > 2)
			call_user_func_array(array($stmt, "bind_param"), array_slice(func_get_args(), 1));
		$stmt->execute();
			
		$meta = $stmt->result_metadata();
			
		// This is the tricky bit dynamically creating an array of variables to use
		// to bind the results
		if (is_object($meta)) {
		while ($field = $meta->fetch_field()) {
			$var = $field->name;
			$$var = null;
			$fields[$var] = &$$var;
		}
			
		call_user_func_array(array($stmt,'bind_result'),$fields);
			
		$i = 0;
		while ($stmt->fetch()) {
			$results[$i] = array();
			foreach($fields as $k => $v)
				$results[$i][$k] = $v;
			$i++;
		}
		} else {
// 			if ($dbConn->insert_id > 0) $results = $dbConn->insert_id;
			$results = $stmt->affected_rows;
		}
		$stmt->close();
	}

	$dbConn->close();
	return $results;
}

function exists($query, $paramTypes) {
	$query .= " LIMIT 1";
	$result = call_user_func_array("result", func_get_args());
	if (count($result) > 0) return $result[0];
	return false;
}
?>