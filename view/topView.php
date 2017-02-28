<!DOCTYPE html>
<html lang="ja">
    <head>
        <?php include 'headerView.php' ?>
    </head>
    <body>
        <?php include 'menuView.php' ?>
        <div class="container" style="margin-top:15px;">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">掲示板一覧</div>
                        <div class="card-block">
                        <?php 
                            $listHtml = "";
                           if(!empty($listData)){
                                $listHtml .= '<div class="list-group">';
                                foreach($listData as $oneData){
                                    $listHtml .= '<a href="index.php?page=detail&action=main&id='.$oneData["id"].'" class="list-group-item list-group-item-action">';
                                    $listHtml .= '<span>['.str_replace('-','/',$oneData['create_time']).']&nbsp;&nbsp;</span>';
                                    $listHtml .= '<div>';
                                    $listHtml .= $oneData['name'];
                                    $listHtml .= '</div>';
                                    $listHtml .= '</a>';
                                }
                                $listHtml .= '</div>';
                                echo $listHtml;
                            } else {
                                echo '投稿されていません。';
                            }
                        ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
