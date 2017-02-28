<?php
/**
 * @brief   Coreモデルクラス
 * @author  Y.Hirano@CodeLike
 */
class fireSignMdl
{
    public $db;

    function __construct()
    {
        if(DB_USE == "1"){
            if(DB_NAME == "Postgresql"){
                $this->db = new PostgreSQL(HOST_NAME, USER_NAME, PASSWORD, DATABASE);
                $ret = $this->db->connect();
                if(!$ret)
                {
                    echo "データベース読み込みエラー"; 
                    die;
                }
            } else if(DB_NAME == "MySql"){
                $this->db = new DBMysql(0, HOST_NAME, USER_NAME, PASSWORD, DATABASE);
                $ret = $this->db->connect();
                if(!$ret)
                {
                    echo "データベース読み込みエラー"; 
                    die;
                }
            }
         } else {
            echo '<div style="color:red;font-size:20px;">DBオブジェクト作成エラー：DBに接続できません。<br />modelを使わないでください。</div>';
         }
    }
}
