<?php
class DBMysql
{
	private $hostName;     // サーバ名
	private $database;     // 対象DB
	private $userName;     // DBユーザ名
	private $password;     // DBパスワード
	private $connection;   // DB接続判定
	private $result;       // 結果リソース
	private $enc = "UTF-8";       

	public function __construct($init_flag=0, $hostName="", $userName="", $password="", $database="")
	{
        if($init_flag == 0)
        {
            $this->hostName = $hostName;
            $this->userName = $userName;
            $this->password = $password;
            $this->database = $database;
            $this->connection = false;
        }
        else
        {
            if($this->inifile !== "")
            {
                $iniArray = parse_ini_file($this->inifile);
                $this->hostName = $iniArray["host_name"];
                $this->userName = $iniArray["user_name"];
                $this->password = $iniArray["password"];
                $this->database = $iniArray["database"];
                $this->connection = false;
            }
        }
	}

    public function _includeConnectInfo()
    {
        $ret_file = is_file($this->iniFile);
        $iniArray = parse_ini_file($this->iniFile);
        $this->hostName = $iniArray["host_name"];
        $this->userName = $iniArray["user_name"];
        $this->password = $iniArray["password"];
        $this->database = $iniArray["database"];
        $this->connection = false;
    }

	public function __destruct()
	{
        @mysqli_free_result($this->result);
        @mysqli_close($this->connection);
	}

	public function connect()
	{
        $this->connection = mysqli_connect($this->hostName, $this->userName, $this->password);
        if($this->connection)
        {
            $selectDbFlg = false;
            $selectDbFlg = mysqli_select_db($this->connection, $this->database);

            if($selectDbFlg)
            {
                mysqli_set_charset($this->connection, $this->enc);
                $ret = true;
            }
            else
            {
                $this->errorMsg("データベースの選択に失敗しました。");
                $ret = false;
            }
        }
        else
        {
            $this->errorMsg("MySQLの接続に失敗しました。");
            $ret = false;
        }

		return $ret;
	}

	/**
	*  クエリーの実行
	*
	*  param : SQL文の文字列
	*  return: BOOL
	*/
	public function Query($sql)
	{
		$this->result = mysqli_query($sql);

		if($this->result)
		{
			if( (strcmp('SELECT', substr($sql,0,6))) or (strcmp('select', substr($sql,0,6))) )
			{
				$ret = $this->result;
			}
			else
			{
				$ret = true;
			}
			$this->_lastSQL = $sql;
		}
		else
		{
			$this->errorMsg("SQLの実行に失敗しました。\n$sql");
			$ret = false;
		}
		
		return $ret;
	}

	public function selectQuery($tableName, $column = null, $where = null)
	{
        $sql = "select * from {$tableName}";

        if(!empty($column) && !empty($where)){
            $sql = "select {$column} from {$tableName} where {$where} ";
        }
        else if(!empty($column)){
            $sql = "select {$column} from {$tableName}";
        } 
        else if(!empty($where)){
            $sql = "select * from {$tableName} where {$where} ";
        }        
        $this->_lastSQL = $sql;
		$this->result = mysqli_query($this->connection,$sql);

		if($this->result)
		{
		    $ret = true;
		}
		else
		{
			$this->errorMsg("SQLの実行に失敗しました。\n$sql");
			$ret = false;
            die;
		}
        $i = 0;
        $data = array();

        while ($row = mysqli_fetch_assoc($this->result)) {
            array_push($data,$row);
        }
		
		return $data;
	}

	public function deleteQuery($tableName, $where = null)
	{
        $sql = "delete from {$tableName}";

        if(!empty($where)){
            $sql = "delete from {$tableName} where {$where} ";
        }        
        $this->_lastSQL = $sql;
		$this->result = mysqli_query($this->connection,$sql);

		if($this->result)
		{
		    $ret = true;
		}
		else
		{
			$this->errorMsg("SQLの実行に失敗しました。\n$sql");
			$ret = false;
            die;
		}
	}

    public function insertQuery($table, $columnArray)
    {
        if($this->connection)
        {
            $sql = "INSERT INTO $table ";
            $column = "(";
            $values = "VALUES(";

            foreach($columnArray as $key => $value)
            {
                $values .= "'$value', ";
                $column .= "$key, ";
            }
            $column = substr($column, 0, -2);
            $values = substr($values, 0, -2);
            $column .= ") \n";
            $values .= ')';
            $sql .= $column. $values;

            $this->_lastSQL = $sql;
            mysqli_query($this->connection, $sql);
        }
        else
        {
            $this->_errormsg = "サーバーに接続されていないため、INSERT文の実行に失敗しました。";
            $ret = false;
        }

        return $ret;
    }


    private function errorMsg($str)
    {
        echo "<pre>";
        var_dump($str);
        echo "</pre>";
    }
}
?>
