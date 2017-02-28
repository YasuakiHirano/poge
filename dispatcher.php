<?php
class Dispatcher
{
    private $sysRoot;
    
    public function setSystemRoot($path)
    {
        $this->sysRoot = rtrim($path, '/');
    }
    public function dispatch($ret_page="", $ret_action="")
    {
        $page = "";
        $action = "";

        if($ret_page !== "")
        {
            $page = $ret_page;
        }
        else
        {
            $page = $_GET["page"];
        }

        if($ret_action !== "")
        {
            $action = $ret_action;
        }
        else
        {
            $action = $_GET["action"];
        }

        //page指定有無チェック 
        if ("" === trim($page)) 
        {
            echo "ページが設定されていません。"; 
            exit;
        }
        
        //action指定有無チェック
        if ("" === trim($action)) {
            echo "ページアクションが設定されていません。"; 
            exit;
        }        

        //モデルファイルが存在した場合読込
        $class = $page.MODEL_FILE_DELIMTER;
        $file = $this->sysRoot.'/model/'.$class.'.php';
        if(file_exists($file))
        {
            require_once $file;
        }
        else
        {
            // 存在しない場合、エラーを出す場合は下記をコメントアウト
            //echo "モデルファイルが存在しません"; 
        }
 

        // クラスファイル読込
        $class = $page.CLASS_FILE_DELIMTER;
        $file = $this->sysRoot.'/controll/'.$class.'.php';
        if(file_exists($file))
        {
            require_once $file;
        }
        else
        {
            echo "404... 指定されたページは見つかりません。"; 
            exit;
        }

        // クラスインスタンス生成
        $controller_class = new $class();
        $controller_class->pageName = $class;

        // アクションメソッドを実行
        $action_method = $action.ACTION_DELIMTER;

        $controller_class->$action_method();
    }
}
