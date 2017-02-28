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
            $this->connection = FALSE;
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
                $this->connection = FALSE;
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
        $this->connection = FALSE;
    }

	public function __destruct()
	{
        @mysql_free_result($this->result);
        @mysql_close($this->connection);
	}

	public function connect()
	{
        $this->connection = mysql_connect($this->hostName, $this->userName, $this->password);

        if($this->connection)
        {
            $selectDbFlg = false;
            $selectDbFlg = mysql_select_db($this->database, $this->connection);
            if($selectDbFlg)
            {
                mysql_set_charset($this->enc);
                $ret = TRUE;
            }
            else
            {
                $this->errorMsg("データベースの選択に失敗しました。");
                $ret = FALSE;
            }
        }
        else
        {
            $this->errorMsg("MySQLの接続に失敗しました。");
            $ret = FALSE;
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
		$this->result = mysql_query($sql);

		if($this->result)
		{
			if( (strcmp('SELECT', substr($sql,0,6))) or (strcmp('select', substr($sql,0,6))) )
			{
				$ret = $this->result;
			}
			else
			{
				$ret = TRUE;
			}
			$this->_lastSQL = $sql;
		}
		else
		{
			$this->errorMsg("SQLの実行に失敗しました。\n$sql");
			$ret = FALSE;
		}
		
		return $ret;
	}

	public function selectQuery($sql)
	{
		$this->result = mysql_query($sql);

		if($this->result)
		{
		    $ret = TRUE;
		}
		else
		{
			$this->errorMsg("SQLの実行に失敗しました。\n$sql");
			$ret = FALSE;
            die;
		}
        $i = 0;
        $data = array();

        while ($row = mysql_fetch_assoc($this->result)) {
            array_push($data,$row);
        }
		
		return $data;
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

            mysql_query($sql);
        }
        else
        {
            $this->_errormsg = "サーバーに接続されていないため、INSERT文の実行に失敗しました。";
            $ret = FALSE;
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
