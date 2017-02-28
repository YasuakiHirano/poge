<?php
/*
* @brief   PostgreSQL操作クラス                 
* @author  Y.Hirano@CodeLike
*/
define ('ENC', 'utf8');

class PostgreSQL
{
    private $_hostName;     // サーバ名
    private $_database;     // 対象DB
    private $_userName;     // DBユーザ名
    private $_password;     // DBパスワード
    private $_connection;   // DB接続判定
    private $_result;       // 結果リソース
    private $_errormsg;     // 直前のエラーメッセージ
    private $_lastSQL;      // 直前のSQL
    private $_enc;          // 文字コード
    private $_strSqlCon;

    /**
    *  コンストラクタ  メンバ変数に値を代入
    */
    public function __construct($hostName, $userName, $password, $database)
    {
        $this->_hostName = $hostName;
        $this->_userName = $userName;
        $this->_password = $password;
        $this->_database = $database;
        $this->_connection = FALSE;
        $this->_enc = ENC;
        $this->_strSqlCon = "host=".$hostName." dbname=".$database." user=".$userName." password=".$password;
    }

    /**
    *  デストラクタ 結果リソースの解放と接続の終了
    */
    public function __destruct()
    {
        pg_close($this->_connection);
        $this->_connection = FALSE;
        $this->_lastSQL = '';
    }

    /**
    *  postgreSQLへの接続とデータベースの選択 
    *  @return true:成功 false:失敗
    */
    public function connect()
    {
        $this->_connection = pg_connect($this->_strSqlCon);

        if($this->_connection) {
            $ret = TRUE;
        }
        else
        {
            $this->_errormsg = "データベース接続失敗".pg_last_error();
            $ret = FALSE;
        }

        return $ret;
    }

    /**
    *  失敗メッセージを取得する
    *  @return SQL失敗メッセージ
    */
    public function getErrorMsg()
    {
        return $this->_errormsg;
    }

    /**
    *  Prepare Statementによるクエリーの実行
    *  @param $sql SQL文
    *  @param $flag 1:トランザクション使用
    *  @param $arrVal 値の配列
    *  @return BOOL
    */
    public function queryPrepare($sql,$flag = 0, $arrVal)
    {
        // セレクトで値がない場合、エラーになるためパラメータ付加
        if($arrVal == null)
        {
            $sql .= " WHERE 1 = $1 ";
            $arrVal = array("1");
        }

        pg_prepare($this->_connection,"",$sql);
        $this->_result = pg_execute($this->_connection,"",$arrVal);

        if($this->_result)
        {
            if( (strcmp('SELECT', substr($sql,0,6))) or (strcmp('select', substr($sql,0,6))) )
            {
                $ret = $this->_result;
            }
            else
            {
                $ret = TRUE;
            }

            $this->_lastSQL = $sql;

            if($flag == 1)
            {
                pg_query("COMMIT");
            }
        }
        else
        {
            $this->_errormsg = "SQLの実行に失敗しました".pg_last_error();
            $ret = FALSE;

             if($flag == 1)
            {
                pg_query("ROLLBACK");
            }
        }
        
        return $ret;
    }

    /**
    *  セレクトクエリーの生成と実行
    *  @param: 対象テーブルの文字列
    *  @param: 対象カラム配列
    *  @param: WHERE文以降の文字列
    *  @return: 結果リソース 失敗時はFALSE
    */
    public function selectQuery($table, $columns = "*", $where = null, $whereParam = null)
    {
        if($this->_connection)
        {
            $sql = "SELECT \n";
            if($columns == "*")
            {
                $sql .= "    ";
                $sql .= "$columns \n";
            }
            else
            {
                foreach($columns as $value)
                {
                    $sql .= "    ";
                    $sql .= $value. ", \n";
                }
                $sql  = substr($sql, 0,  -3);
                $sql .= " \n";
            }
            $sql .= "FROM \n";
            $sql .= "    $table \n";

            if($where != null)
            {
                $sql .= " WHERE $where \n";
            }

            $this->_lastSQL = $sql;
            $ret = $this->queryPrepare($sql, 0, $whereParam);
        }
        else
        {
            $this->_errormsg = 'SQLの実行に失敗しました。';
            $ret = FALSE;
        }
            
        return $ret;
    }

    /**
    *  インサートクエリーの生成と実行
    *  @param   対象テーブル名
    *  @param   データ配列
    *  @return  BOOL
    */
    public function insertQuery($table, $columnArray)
    {
        pg_query("BEGIN"); //トランザクション開始

        if($this->_connection)
        {
            $sql = "INSERT INTO $table ";
            $column = "(";
            $values = "VALUES(";

            $count = 1;
            $valArr = array();
            foreach($columnArray as $key => $value)
            {
                $values .= " $".$count." , ";
                $column .= "$key, ";

                array_push($valArr,$value);
                $count++;
            }
            $column = substr($column, 0, -2);
            $values = substr($values, 0, -2);
            $column .= ") \n";
            $values .= ')';
            $sql .= $column. $values;

            $ret = $this->queryPrepare($sql, 1, $valArr);
            $this->_lastSQL = $sql;
        }
        else
        {
            $this->_errormsg = "サーバーに接続されていないため、INSERT文の実行に失敗しました。";
            $ret = FALSE;
        }

        return $ret;
    }

    /**
    *  結果リソースから行数を取得
    *  @return 行数 失敗時はFALSE
    */
    public function getRecordCount()
    {
        if($this->_connection)
        {
            $ret = pg_num_rows($this->_result);
        }
        else
        {
            $this->_errormsg = "行数取得に失敗しました。";
            $ret = FALSE;
        }

        return $ret;
    }

    /**
    *  結果リソースからカラム数を取得
    *  @return カラム数 失敗時はFALSE
    */
    public function getFieldsCount()
    {
        if($this->_connection)
        {
            $ret = pg_num_fields($this->_result);
        }
        else
        {
            $this->_errormsg = "列数取得に失敗しました。";
            $ret = FALSE;
        }

        return $ret;
    }

    /**
    * postgreSQLの接続解除と結果リソースの解放
    */
    public function close()
    {
        if($this->_connection)
        {
            pg_close($this->_connection);
            $this->_connection = FALSE;
            $this->_lastSQL = '';
        }
        else
        {
            $this->_errormsg = "結果リソースの解放と接続終了に失敗しました。";
        }
    }

    /**
    * 最後に実行されたSQLを表示
    */
    public function printSQL()
    {
        echo "<pre>";
        print_r($this->_lastSQL);
        echo "</pre>";
    }

    /**
    * エラーメッセージの表示
    */
    public function errorMessage()
    {
        echo "<pre>";
        print_r($this->_errormsg);
        echo "</pre>";
    }
}
