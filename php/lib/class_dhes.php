<?php
//requires dhrest
class dhes {
	private $config = array(
		"host"=>"elk.dhdev.org",
		"port"=>"8080",
		"auth"=>"dhayes:3cewumef",
	);
	/*private $config = array(
		"host"=>"localhost",
		"port"=>"9200",
		"auth"=>false,
	);*/
	public $ret_array = true;
	
	private $index;
	private $type;
	
	public $bulk_data = array();
	
	function __construct($index="",$type="") {
		$this->setIndex($index);
		$this->setType($type);
	}
	
	function index($document=array(),$id="") {
		if(empty($document)) return false;
		
		$json = json_encode($document);
		
		$url = $this->url($this->index."/".$this->type);
		if($id != "") {
			$url.="/".$id;
			$return = $this->parse(dhrest::put($url,$json,$this->config["auth"]));
		} else {
			$return = $this->parse(dhrest::post($url,$json,$this->config["auth"]));
		}
		if($this->ret_array) return (array) $return;
		return $return;
	}
	
	function addBulkAction($action_arr,$param_arr=array()) {
		$this->bulk_data[] = json_encode($action_arr);
		if(!empty($param_arr)) $this->bulk_data[] = json_encode($param_arr);
	}
	function bulk($data=array()) {
		if(empty($data)) {
			$data = $this->bulk_data;
			$this->bulk_data = array();
		}
		$string = "";
		foreach($data as $k=>$ob) {
			$string.=$ob."\n";
		}
		$url = $this->url("_bulk");
		$return = $this->parse(dhrest::post($url,$string,$this->config["auth"]));
		if($this->ret_array) return (array) $return;
		return $return;
	}
	
	function search($args=array(),$path="",$size="",$from="") {
		if($path != "") {
			$url = $this->url($path."/_search");
		} else {
			$url = $this->url("_search");
		}
		
		if($size != "") $url.="?size=".$size;
		if($size == "" && $from != "") $url.="?from=".$from;
		if($size != "" && $from != "") $url.="&from=".$from;
		
		if(is_array($args)) $args=json_encode($args);

		$return = $this->parse(dhrest::post($url,$args,$this->config["auth"],600));
		if($this->ret_array) return (array) $return;
		return $return;
	}
	
	public function indexExists($index="") {
		if($index == "") $index = $this->index;
		$url = $this->url($index);
		$return = $this->parse(dhrest::head($url,"",$this->config["auth"]));
		
		if($this->status == 200) return true;
		return false;
	}
	
	public function setIndex($index) {
		$this->index = $index;
	}
	public function setType($type) {
		$this->type = $type;
	}
	
	function url($path) {
		return "http://".$this->config["host"].":".$this->config["port"]."/".$path;
	}
	
	function parse($response) {
		$this->response = $response;
		$this->status = $response["status"];
		$this->header = $response["header"];
		if($this->ret_array)
			$this->data = json_decode($response["data"],true);
		else
			$this->data = json_decode($response["data"]);
		return $this->data;
	}
}
