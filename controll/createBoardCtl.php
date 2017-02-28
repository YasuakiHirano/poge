<?php
/**
 * @brief   新規作成ページを表示するコントロールクラス
 * @author  Y.Hirano@CodeLike
 */
class createBoardCtl extends fireSignCtl
{
    private $topMdl = null;

    function __construct(){
        parent::__construct();
        $this->createBoardMdl = new createBoardMdl();
    }

    function mainAct()  
    {
        $this->viewData = array('board_titles' => $titles);

        // top view表示
        $this->showView('createBoardView');
    }
    
    function makeBoardAct(){
        $postVal = $this->request->getPost();
        
        $checkKeys = array(
          'selIcon' => 'アイコン',
          'user_name' => '名前',
          'board_title' => 'タイトル',
          'about_text' => '説明文',
          'password' => 'パスワード'
         );

        $res = $this->emptyCheck($postVal, $checkKeys);
        if(empty($res)){
            $arr = array('icon_number' => $postVal['selIcon'],
                         'user_name' => $postVal['user_name'], 
                         'name' => $postVal['board_title'],
                         'about_text' => $postVal['about_text'], 
                         'password' => $postVal['password']
                        );
            $this->createBoardMdl->insertBoard($arr);
            header('Location:index.php');
        } else {
            $returnTag = '<a href="index.php?page=createBoard&action=main">'.
                            '<button type="button" class="btn btn-default btn-block">戻る</button>'.
                         '</a>';
            $this->viewData = array('error' => $res ,'returnTag' => $returnTag);
            $this->showView('errorView');
        }
    }

}
