<?php
/**
 * dhPDO v1.0
 * @author randy
 * @param array $config array with following elements dbtype,dbhost,dbport,dbuser,dbpass,dbname
 */
class dbpdo extends PDO {
	public $debug = false;
	public $debugOpts = array("when"=>"post");
	public $failed = false;
	public $failedMessage = null;
	
	public $log_failed = false;
	
	public function __construct($config) {
		$dsn=$config["dbtype"].':host='.$config["dbhost"].";port=".$config["dbport"].";dbname=".$config["dbname"];
		$user=$config["dbuser"];
		$passwd=$config["dbpass"];
		$persist = true;
		if(isset($config["persist"])) {
			$persist =  $config["persist"];
		}
		$compress = false;
		if(isset($config["compress"])) {
			$compress =  $config["compress"];
		}
		$options = array(
			PDO::ATTR_PERSISTENT => $persist, 
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
			PDO::MYSQL_ATTR_COMPRESS => $compress
		);

		try {
			parent::__construct($dsn, $user, $passwd, $options);
		} catch (PDOException $e) {
			$this->error = $e->getMessage();
		}
		
		if(isset($config["debug"])) {
			$this->setDebug($config["debug"]);
		}
		if(isset($config["log_failed"]))
			$this->log_failed = $config["log_failed"] ? true : false;
	}
	function setDebug($debug,$opts=array()) {
		$this->debug = $debug;
		if(count($opts)>=1 && is_array($opts)) {
			foreach($opts as $k=>$v) {
				$this->setDebugOpts($k,$v);
			}
		}
	}
	function setDebugOpts($item,$value) {
		echo "Set $item to $value\n";
		$this->debugOpts[$item] = $value;
	}
	function bind(&$sth,$pos,$value,$type=null) {
		if( is_null($type) ) {
			switch( true ) {
				case is_int($value):
					$type = PDO::PARAM_INT;
					break;
				case is_bool($value):
					$type = PDO::PARAM_BOOL;
					break;
				case is_null($value):
					$type = PDO::PARAM_NULL;
					break;
				default:
					$type = PDO::PARAM_STR;
			}
		}
		$sth->bindValue($pos,$value,$type);
	}
	function run($sql,$arr=null) {
		$this->failed = false;
		$this->failedMessage = null;
		$sth = $this->prepare($sql);
		if(is_array($arr)) {
			foreach($arr as $k=>$v) {
				$this->bind($sth,$k+1,$v);
			}
		} elseif($arr!=null && $arr!="") {
			$this->bind($sth,1,$arr);
		}
		try {
			if($this->debug && isset($this->debugOpts["when"]) && $this->debugOpts["when"] == "pre") {
				$this->printDebug($sql,$arr,"pre","");
			}
			$time_start = microtime(true);
			$sth->execute();
			$time_end = microtime(true);
			$exectime = "";
			if($this->debug && isset($this->debugOpts["when"]) && $this->debugOpts["when"] == "post") {
				$time = $time_end - $time_start;
				$this->printDebug($sql,$arr,"post",$time);
			}
		}
		catch (Exception $e) {
			$this->failedMessage = $e->getMessage();
			$this->failed = true;
			$this->errors($e,$sql,$arr);
		}
		return $sth;
	}
	function effectedRows($sth) {	//cnc
		return $sth->rowCount();
	}
	function fetch($sth,$type="") {
		if($type == "") {
			$type = PDO::FETCH_ASSOC;
		} elseif($type == "array") {
			$type = PDO::FETCH_BOTH;
		}
		$row=$sth->fetch($type);
		return $row;
	}
	function fetchAll($sth,$type="") {
		if($type == "") {
			$type = PDO::FETCH_ASSOC;
		} elseif($type == "array") {
			$type = PDO::FETCH_BOTH;
		}
		$result=$sth->fetchAll($type);
		return $result;
	}
	function runFetchAll($sql,$arr=null) {
		$sth = $this->run($sql,$arr);
		$data = array();
		while($row = $this->fetch($sth)) {
			$data[] = $row;
		}
		return $data;
	}
	function getSingle($sql,$arr,$field="") {
		$sth = $this->run($sql,$arr);
		$result = $this->fetch($sth);
		if($field != "") {
			if(isset($result[$field])) {
				return $result[$field];
			}
		} else {
			return $result;
		}
		return false;
	}
	function printDebug($sql,$arr,$when="pre",$data="") {
		$nl = "<br />";
		if(php_sapi_name() == "cli") {
			$nl="\n";
		} else {
			echo "<div class='debug'>";
		}
		if($when == "post") {
			$data = round($data,5);
			echo "[DB] Executed in: $data seconds".$nl;
		}
		echo "[DB] Query: $sql".$nl;
		$string = "";
		$parms = true;
		if(is_array($arr) && count($arr)>=1) {
			foreach($arr as $k=>$v) {
				$string.=" [$k]=>$v,";
			}
		} else {
			if(is_array($arr)) {
				$parms = false;
			} else {
				$string = $arr;
			}
		}
		$string = trim(trim($string),",");
		if($parms) { echo "[DB] Params: $string".$nl; }
		if(php_sapi_name() != "cli") {
			echo "</div>";
		}
	}
	function errors($e,$sql="",$parms="") {
		$arr["message"] = $e->getMessage();
		$arr["sql"] = $sql;
		$arr["parms"] = $parms;
		$arr["trace"] = $e->getTraceAsString();
		$return = print_r($arr,true);
		$nl = "<br />";
		if(php_sapi_name() == "cli") {
			$nl="\n";
			echo "[DB] ERROR:$nl";
			echo $return."$nl";
			
		} else {
			$return = nl2br($return);
			if($this->debug) echo "<div class='debug'>[DB] ERROR:$nl";
			if($this->debug) echo $return."</div>";
			
		} 
	}
	function createQuestionMarks($array) {
		$string = "";
		foreach($array as $blah) {
			$string.=",?";
		}
		return trim($string,",");
	}
}
