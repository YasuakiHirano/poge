<?php
/**
 * @brief   リクエストオブジェクトクラス
 * @author  Y.Hirano@CodeLike
 */
// リクエスト変数抽象クラス
abstract class requestVal
{
    protected $_values;

    public function __construct() 
    {
        $this->setValues();
    }

    // パラメータ値設定
    abstract protected function setValues();

    // 指定キーのパラメータを取得
    public function get($key = null)
    {
        $ret = null;
        if (null == $key) {
            $ret = $this->_values;
        } else {
            if (true == $this->has($key)) {
                $ret = $this->_values[$key];
            }
        }
        return $ret;
    }

    // 指定のキーが存在するか確認
    public function has($key)
    {
        if (false == array_key_exists($key, $this->_values)) {
            return false;
        }
        return true;
    }
}

// POST変数クラス
class Post extends requestVal
{
    protected function setValues()
    {
        foreach ($_POST as $key => $value) {
            $this->_values[$key] = htmlspecialchars($value);
        }		
    }		
}

// GET変数クラス
class QueryString extends requestVal
{
    protected function setValues()
    {
        foreach ($_GET as $key => $value) {
            $this->_values[$key] = $value;
        }		
    }		
}

class fireSignRequest
{
    // POSTパラメータ
    private $_post;
    // GETパラメータ
    private $_query;
    
    // コンストラクタ@
    public function __construct()
    {
        $this->_post = new Post();
        $this->_query = new QueryString();
    }

    // POST変数取得
    public function getPost($key = null)
    {
        if (null == $key) {
            return $this->_post->get();
        }
        if (false == $this->_post->has($key)) {
            return null;
        }
        return $this->_post->get($key);
    }

    // GET変数取得
    public function getQuery($key = null)
    {
        if (null == $key) {
            return $this->_query->get();
        }
        if (false == $this->_query->has($key)) {
            return null;
        }
        return $this->_query->get($key);
    }

    //セッションへの値設定
    public function setSession($key = null,$val = null)
    {
        if($key != null)
        {
            $_SESSION[$key] = $val;
        }
    }
    //セッションの値取得
    public function getSession($key)
    {
        if($key != null)
        {
            return $_SESSION[$key];
        }
    }

}

?>
