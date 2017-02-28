<?php
/**
 * @brief   TOPページを表示するコントロールクラス
 * @author  Y.Hirano@CodeLike
 */
class topCtl extends fireSignCtl
{
    private $topMdl = null;

    function __construct(){
        parent::__construct();
        $this->topMdl = new topMdl();
    }

    function mainAct()  
    {
        // 投稿済みのタイトルを取得
        $data = $this->topMdl->getBoard();
        $this->viewData = array("listData" => $data); 

        // top view表示
        $this->showView('topView');
    }
}
