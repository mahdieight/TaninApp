<?php
class DB{

public $bridge;
public static $instance;


public static function getInstance(){
  if(empty(self::$instance)){
    self::$instance = new DB();
  }

  return self::$instance;
}

public function __construct($db_config = array()){

  if(!empty($db_config)){
    $db_host =  $hostname;
    $db_user =  $username;
    $db_pass =  $password;
    $db_name =  $dbname;
  }else{
    $taninAppConfig =new  taninAppConfig();
    $db_host =  $taninAppConfig->db_host;
    $db_user =  $taninAppConfig->db_user;
    $db_pass =  $taninAppConfig->db_pass;
    $db_name =  $taninAppConfig->db_name;
  }

  $this->bridge = @new mysqli($db_host,$db_user,$db_pass,$db_name);

  if($this->bridge->connect_error){
    echo 'Error while conction db...';
    exit;
  }else{
    $this->bridge->query('SET NAMES `utf8`');
  }
}

private function safeQuery(&$sql,$data = array()){

foreach ($data as $key => $value) {
  $value = @$this->bridge->real_escape_string($value);
  if(!is_numeric($value) && $value != "NULL"){
			$value = "'$value'";
  }
	$sql = str_replace(":$key",$value,$sql);

}
//dump($sql);
return $this->bridge->query($sql);
}

public function getAllRecords($query,$data = array()) {
  $records = $this->safeQuery($query,$data);

  if(empty($records)){
    return array();
  }
  if($records->num_rows < 0){
    return array();
  }else{
    $result = array();
    while($rows =$records->fetch_assoc()){
      $result[] = $rows;
    }
    return $result;
  }
}


public function getRocord($query , $data =array()){
  $records = $this->getAllRecords($query , $data);
  if (empty($records)) {
    return array();
  }else{
    return $records[0];
  }
}

public function insertRecord($query,$data = array()){
  $result = $this->safeQuery($query,$data);
  return $result;
}

public function modifyRecord($query,$data = array()){
	$result = $this->safeQuery($query,$data);
	return $result;
}

}
 ?>
