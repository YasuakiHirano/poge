<?php
/**
 * @brief   TOPページを表示するコントロールクラス
 * @author  Y.Hirano@CodeLike
 */
class topCtl extends fireSignCtl
{
    private $topMdl = null;
    private $pageTitle = 'poge';

    function __construct(){
        parent::__construct();
        $this->topMdl = new topMdl();
    }

    function mainAct()  
    {
        // 投稿済みのタイトルを取得
        $data = $this->topMdl->getBoard();
        $this->viewData = array('title' => $this->pageTitle, "listData" => $data); 

        // top view表示
        $this->showView('topView');
    }
}
