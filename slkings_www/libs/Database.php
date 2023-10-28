<?php
class Database extends PDO
{
    protected  $readonly;
	
    public function __construct($__ENV_DB_TYPE__, $__ENV_DB_HOST__,$__ENV_DB_PORT__, $__ENV_DB_NAME__, $__ENV_DB_USER__, $__ENV_DB_PASS__,$READ_ONLDY = true){   
        try{
        	parent::__construct($__ENV_DB_TYPE__.':host='.$__ENV_DB_HOST__.';port='.$__ENV_DB_PORT__.';dbname='.$__ENV_DB_NAME__, $__ENV_DB_USER__, $__ENV_DB_PASS__);
        	$msg = $__ENV_DB_HOST__."DB Initialization succeeded";
        	//$this->log($msg);
        }catch(PDOException $e){
        	$msg = $__ENV_DB_HOST__."DB Initialization error".$e->getMessage();
        	//echo $msg;
        	$message = date("Y/m/d H:i:s")."|DB-MSG:".$msg.chr(13).chr(10);
        	 
        	if(!is_dir(__ENV_LOG_DIR__)){
        		@mkdir(__ENV_LOG_DIR__);
        	}
        	$newfilename = __ENV_LOG_DIR__.DIRECTORY_SEPARATOR."db_err_".date("Y-m-d").".log";
        	
        	if(__ENV_DEVELOP__ == 1){
        		$newfilename = __ENV_LOG_DIR__.DIRECTORY_SEPARATOR."dev_log.log";
        	}
        	
        	$fp = fopen($newfilename, "a");
        	if(!$fp) {
        		//die("Can not open the file == > check setting log dir");
        		return;
        	}
        	fwrite($fp, $message);
        	fclose($fp);
        	echo "Database connection error !";  
        	//header('location: ' .__ENV_URL__."error/mbox");
        	exit();
        }
        
        //parent::setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTIONS);
    }    
    
    private function log($msg,$filename="db"){
    	
    	$message = date("Y/m/d H:i:s")."|DB-MSG:".$msg.chr(13).chr(10);
    	
    	if(!is_dir(__ENV_LOG_DIR__)){
    		@mkdir(__ENV_LOG_DIR__);
    	}
    	$newfilename = __ENV_LOG_DIR__.DIRECTORY_SEPARATOR.$filename."_".date("Y-m-d").".log";
    	if(__ENV_DEVELOP__ == 1){
    		$newfilename = __ENV_LOG_DIR__.DIRECTORY_SEPARATOR."dev_log.log";
    	}
    	$fp = fopen($newfilename, "a");
    	if(!$fp) {
    		//die("Can not open the file == > check setting log dir");
    		return;
    	}
    	fwrite($fp, $message);
    	fclose($fp);
    }
    /**
     * select
     * @param string $sql An SQL string
     * @param array $array Paramters to bind
     * @param constant fetchMode A PDO Fetch mode
     * @return mixed
     */
    public function select($sql, $array = array(), $fetchMode = PDO::FETCH_ASSOC){
        $sth = $this->prepare($sql);
        foreach ($array as $key => $value) {
        	//$this->log("select->$key=>".$value);
            $sth->bindValue("$key", $value);
        }        
        //$this->log("select->queryString=>".$sth->queryString);
        //$sth->execute();
        if( !$sth->execute() ){
        	$info = $sth->errorInfo();
        	if(is_array($info)){
        		$errmsg="";
        		for($i=0; $i < count($info) ; $i++){
        			$errmsg .="[{$i}] : ". $info[$i]." ";
        		}        		
        		$this->log("Database select error : ".$errmsg."=>".$sql);
        	}
        	return Array();
        }
        return $sth->fetchAll($fetchMode);
    }
    public function selectmulit($sql, $fetchMode = PDO::FETCH_ASSOC){
    	$sth = $this->query($sql);
    	return $sth;
    }
    /**
     * insert
     * @param string $table A name of table to insert into
     * @param string $data An associative array
     */
    public function insert($table, $data){
    	if($this->readonly){
    		$this->log("Database insert error : ReadOnly");
    		return 0;
    	}
    	ksort($data);    
    	$fieldNames = implode('`, `', array_keys($data));
    	$fieldValues = ':' . implode(', :', array_keys($data));
    
    	//$this->log("INSERT INTO $table (`$fieldNames`) VALUES ($fieldValues)");
    	$sth = $this->prepare("INSERT INTO $table (`$fieldNames`) VALUES ($fieldValues)");
    
    	foreach ($data as $key => $value) {
   			$sth->bindValue(":$key", $value);
    	}
    	if( $sth->execute() ){
    		return 1;
    	}
    
    	$info = $sth->errorInfo();
    	$this->log("Database insert error : ".$info[0]);
    	return 0;
    }
    public function insert2($table, $data){
    	
    	if($this->readonly){
    		$this->log("Database insert error : ReadOnly");
    		return 0;
    	}
        ksort($data);        
        
        $fieldNames = implode('`, `', array_keys($data));
        $fieldValues = array();
        
        foreach ($data as $key => $value) {
        	
        	switch($value["type"]){
        		case "__TIME__":
        			$fieldValues[] = "DATE_FORMAT( NOW(), '%H:%i:%s')";
        			break;
        		case "__DAY__":
        			$fieldValues[] = "DATE_FORMAT( CURDATE(), '%Y-%m-%d')";
        			break;
       			case "__NULL__":
       				$fieldValues[] = "NULL";
       				break;  
       			case "__TEXT__":
       				$fieldValues[] = $this->quote($value["value"]);
       				break;
        		default:
        			$fieldValues[] = "'".$value["value"]."'";
        			break;
        	}
        }
        
        $fieldValuesResult = implode(',', $fieldValues);
      //  $this->log("INSERT INTO $table (`$fieldNames`) VALUES ($fieldValuesResult)");
        $sth = $this->prepare("INSERT INTO $table (`$fieldNames`) VALUES ($fieldValuesResult)");
        
       // $this->log("queryString=>".$sth->queryString);       
    
        if( $sth->execute() ){
        	return 1;
        }
        
        $info = $sth->errorInfo();        
        if(is_array($info)){
        	$errmsg="";
        	for($i=0; $i < count($info) ; $i++){
        		$errmsg .="[{$i}] : ". $info[$i]." ";
        	}
        	$this->log("Database insert error : ".$errmsg);
        }
        
        return 0;
    }
    public function execDml($sql,$arrayData){    
    	$sth = $this->prepare($sql);
    //	$this->log("execDml->queryString=>".$sth->queryString);    	
    	
    	if( !$sth->execute($arrayData)){
    		$info = $sth->errorInfo();
    		if(is_array($info)){
    			$errmsg="";
    			for($i=0; $i < count($info) ; $i++){
    				$errmsg .="[{$i}] : ". $info[$i]." ";
    			}
    			$this->log("Database execDml error : ".$errmsg);
    		}
    		return 0;
    	}
    	return 1;
    }
     
    public function updateDml($sql,$arrayData){
    
    	$sth = $this->prepare($sql);
    	if( $sth->execute($arrayData)){
    		if($sth->rowCount()){
    			return $sth->rowCount(); //업데이트 대생갯수반환
    		}
    		return -1; // 업데이트 대상이 없는경우 데이타가 동일한경우 포함.
    	}
    	$info = $sth->errorInfo();
    	if(is_array($info)){
    		$errmsg="";
    		for($i=0; $i < count($info) ; $i++){
    			$errmsg .="[{$i}] : ". $info[$i]." ";
    		}
    		$this->log("Database execDml error : ".$errmsg);
    	}
    	return 0;
    }
    
    public function execStatement($statement){
    
    	if($this->readonly){
    		$this->log("Database insert error : ReadOnly");
    		return 0;
    	}
    
    	$sth = $this->prepare($statement);
    
    	if( $sth->execute() ){
    		return 1;
    	}
    
    	$info = $sth->errorInfo();
    	$this->log("Database execStatement error : ".$info[0]);
    	return 0;
    }
    /**
     * update
     * @param string $table A name of table to insert into
     * @param string $data An associative array
     * @param string $where the WHERE query part
     */
    public function update($table, $data, $where)
    {
    	if($this->readonly){
    		$this->log("Database update error : ReadOnly");
    		return 0;
    	}    	
        ksort($data);
        $fieldDetails = NULL;
        foreach($data as $key=> $value) {
            $fieldDetails .= "`$key`=:$key,";
        }
        $fieldDetails = rtrim($fieldDetails, ',');
        
        $sth = $this->prepare("UPDATE $table SET $fieldDetails WHERE $where");
        
        foreach ($data as $key => $value) {
            $sth->bindValue(":$key", $value);
        }
        if( $sth->execute() ){
        	return 1;
        }
        $info = $sth->errorInfo();
        $this->log("Database update error : ".$info[0]);
        return 0;
    }
    
    /**
     * delete
     * 
     * @param string $table
     * @param string $where
     * @param integer $limit
     * @return integer Affected Rows
     */
    public function delete($table, $where, $limit = 1){
    	if($this->readonly){
    		$this->error->log("Database insert error : ReadOnly");
    		return 0;
    	}
        return $this->exec("DELETE FROM $table WHERE $where LIMIT $limit");
    }
}