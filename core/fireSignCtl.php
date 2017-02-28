<?php
/**
 * @brief   Coreコントロールクラス
 * @author  Y.Hirano@CodeLike
 */
require_once 'fireSignRequest.php';
class fireSignCtl
{
    public $request;
    public $db;
    public $debug;
    public $viewData;
    public $pageName;

    function __construct()
    {
        $this->debug = new Debug();
        $this->request = new fireSignRequest();
    }

    //ログインしているか判断
    function loginJudge()
    {
        $loginid = '';
        $loginid = $this->request->getSession("login_id");
        if($loginid == '')
        {
            header("Location:index.php"); 
        }
    }

    //viewの表示
    function showView($page)
    {
        extract($this->viewData);
        require_once VIEW_DIR.$page.".php";
    }

    function debugViewData(){
        var_dump($this->viewData);
    }

    function emptyCheck($postVal, $checkKeys){
        $emptyKey = array();
        $checkStr = '';
        foreach($postVal as $key => $checkData){
            if(empty($checkData)){
               $emptyKey[] .= $key; 
            }
        }
        foreach($emptyKey as $key){
            $checkStr .= $checkKeys[$key].'が空です。値を入力してください。'.'<br />';
        } 
        return $checkStr;
    }
}
