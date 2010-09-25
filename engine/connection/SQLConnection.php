<?php

/**
 * Description of SQLConnection
 *
 * @author sarriaroman
 */
class SQLConnection extends Connection {

	private $query;

	private $result;

        function __construct() {
            parent::__construct();
        }

	function escape($string) {
		if(get_magic_quotes_runtime())
			$string = stripslashes($string);
		return @mysql_real_escape_string($string);
	}

	function query($query, $options = null) {

		$this->query = $query;
		if($this->result = mysql_query($this->query) or die(mysql_error() . " " . $query)){
			return true;
		}else{
			return false;
		}


	}

	public function select($tabela, $campos = '*', $where = '', $orderBy = '', $order = '', $limit = '') {

                if( $campos ) {
                    if( is_array($campos) ) $campos = implode (", ", $campos);
                }
		$query = " SELECT " . $campos . " FROM " . $tabela;
		if($where){
			if(is_array($where)){
				$options = "";
				$i = sizeof($where);
				foreach($where as $key=> $value){
					if(! is_int($value) && ! is_bool($value)){
						$value = "'" . $value . "'";
					}
					$key = str_replace('?', $value, $key);
					if(preg_match("/\|\|/", $key)){
						$sinal = 'OR';
						$key = str_replace('||', '', $key);
					}else{
						$sinal = 'AND';
					}
					$options .= ' ' . ($i > 0 ? $sinal : '') . ' ' . $key . ' ';
					$i --;
				}
				$query .= " WHERE TRUE " . $options;
			}else{
				$query .= " WHERE " . $where;
			}
		}
		if($orderBy)
			$query .= " ORDER BY " . $orderBy;
		if($order && $orderBy)
			$query .= " " . $order;
		if($limit)
			$query .= " LIMIT " . $limit;
		$this->query($query);
	}

	public function fetchOne() {

		$row = mysql_fetch_object($this->result);
		return (object) $row;
	}

	public function fetchAll() {

		$objects = array();
		while($rows = mysql_fetch_object($this->result)){
			array_push($objects, $rows);
		}
		return new ArrayObject($objects);
	}

	public function insert($tabela, $campos) {

		$query = "INSERT INTO " . $tabela . " ";
		$i = sizeof($campos);

		$values = $keys = "";

		foreach($campos as $key=> $value){

			if(! is_int($value) && ! is_bool($value)){
				$value = "'" . $value . "'";
			}

			$keys .= $key;
			$values .= $value;

			if($i > 1){
				$keys .= ', ';
				$values .= ', ';
			}
			$i --;
		}

		$query .= " (" . $keys . ") VALUES(" . $values . ") ";
		return $this->query($query);
	}

	public function getQuery(){
		return $this->query;
	}


	public function delete($tabela, $where = '', $limit = 1) {

		$query = " DELETE FROM " . $tabela;
		if($where){
			if(is_array($where)){
				$options = "";
				$i = sizeof($where);
				foreach($where as $key=> $value){
					if(! is_int($value) && ! is_bool($value)){
						$value = "'" . $value . "'";
					}
					$key = str_replace('?', $value, $key);
					if(preg_match("/\|\|/", $key)){
						$sinal = 'OR';
						$key = str_replace('||', '', $key);
					}else{
						$sinal = 'AND';
					}
					$options .= ' ' . ($i > 0 ? $sinal : '') . ' ' . $key . ' ';
					$i --;
				}
				$query .= " WHERE TRUE " . $options;
			}else{
				$query .= " WHERE " . $where;
			}
		}

		if($limit)
			$query .= " LIMIT " . $limit;
		$this->query($query);
	}


}

?>
