<?php
/**
 * @brief   詳細ページを表示するコントロールクラス
 * @author  Y.Hirano@CodeLike
 */
class detailCtl extends fireSignCtl
{
    private $detailMdl = null;

    function __construct(){
        parent::__construct();
        $this->detailMdl = new detailMdl();
    }

    function mainAct()  
    {
        // 投稿済みのタイトルを取得
        $id = $this->request->getQuery('id');
        $data = $this->detailMdl->getBoard($id)[0];


        // 返信されたメッセージを取得
        $id = $this->request->getQuery('id');
        $msgData = $this->detailMdl->getMessage($id);

        $this->viewData = array('title' => $this->pageTitle, 
                                'user_name' => $data['user_name'],
                                'icon_number' => $data['icon_number'],
                                'name' => $data['name'],
                                'about_text' => $data['about_text'],
                                'create_time' => str_replace('-', '/',$data['create_time']),
                                'update_time' => $data['update_time'],
                                'id' => $id,
                                'messageArray' => $msgData
                          );

        // top view表示
        $this->showView('detailView');
    }

    function insertMessageAct(){
        $id = $this->request->getQuery('id');
        $postVal = $this->request->getPost();

        $checkKeys = array(
          'selIcon' => 'アイコン',
          'user_name' => '名前',
          'message' => '内容'
         );
        $res = $this->emptyCheck($postVal, $checkKeys);

        if(empty($res)){
            $parm = array(
                        'board_id' => $id,
                        'icon_number' => $postVal['selIcon'],
                        'user_name' => $postVal['user_name'],
                        'message' => $postVal['message']
                    );
            $this->detailMdl->insertMessage($parm);
            header("Location:index.php?page=detail&action=main&id=".$id);

        } else {
            $returnTag = '<a href="index.php?page=detail&action=main&id='.$id.'">'.
                            '<button type="button" class="btn btn-default btn-block">戻る</button>'.
                         '</a>';
            $this->viewData = array('error' => $res ,'returnTag' => $returnTag);
            $this->showView('errorView');
        }
    }

    function deleteBoardAct(){
        $postVal = $this->request->getPost();
        $result = $this->detailMdl->passwordCheck($postVal['delId'], $postVal['delPassword']);

        if($result){
            $this->detailMdl->deleteBoard($postVal['delId']);
            $this->viewData = array('messageTitle' => '削除確認','message' => '削除しました。');
            $this->showView('confirmView');
        } else {
            $returnTag = '<a href="index.php?page=detail&action=main&id='.$postVal['delId'].'">'.
                            '<button type="button" class="btn btn-default btn-block">戻る</button>'.
                         '</a>';
            $this->viewData = array('error' => 'パスワードが間違っています。' ,'returnTag' => $returnTag);
            $this->showView('errorView');
        }
    }
}
