<!DOCTYPE html>
<html lang="ja">
    <head>
        <?php include 'headerView.php' ?>
    </head>
    <body>
        <?php include 'menuView.php' ?>
        <input type="hidden" id="imageDir" value="<?php echo IMAGE_DIR ?>" />
        <div class="container" style="margin-top:15px;">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header"><?php echo $name ?></div>
                        <div class="card-block">
                            <div class="message-date">投稿日：<?php echo $create_time ?></div>
                            <div class="container">
                                <div class="message-left-image">
                                    <div class="icon-circle">
                                        <img src="<?php echo IMAGE_DIR ?>icon<?php echo $icon_number ?>.png" class="icon-area"/>
                                    </div>
                                    <div class="message-left-name">
                                        <?php echo $user_name ?>
                                    </div>
                                </div>
                                <div class="message-area">
                                    <?php echo nl2br($about_text) ?>
                                </div>
                            </div>
                            <div id="delButtonArea" style="width:100%;margin-top:20px;text-align:right;">
                                <button class="btn btn-danger" onclick="delButton();">削除</button>
                            </div>
                            <div id="delArea" style="width:100%;margin-top:20px;text-align:right;display:none;">
                                <form action="index.php?page=detail&action=deleteBoard" method="POST" id="formDeleteBoard">
                                    <label for="delPassword">パスワード:</label>
                                    <input type="hidden" name="delId" value="<?php echo $id ?>"/>
                                    <input type="password" name="delPassword" id="delPassword" maxlength="20" />
                                    <button type="button" class="btn btn-danger" onclick="deleteSubmit();">決定</button>
                                </form>
                            </div>
                       </div>
                    </div>
                </div>
            </div>
            <?php
                $resHtml = '<div class="row">';
                $resHtml .= '<div class="col-md-12">';
                foreach($messageArray as $oneMsg){
                    $icon = '<div class="icon-circle" >'.
                                '<img src="'.IMAGE_DIR.
                                    "icon{$oneMsg['icon_number']}.png".'" class="icon-area"/>'.
                             '</div>';

                    $resHtml .= '<div class="card">';
                    $resHtml .= '<div class="card-block">'.
                                    '<div class="message-date">投稿日：'.str_replace('-', '/', $oneMsg['create_time']).'</div>'.
                                    '<div class="container">'.
                                        '<div class="message-left-image">'.
                                            $icon.
                                            '<div class="message-left-name">'.
                                                $oneMsg['user_name'].
                                            '</div>'.
                                        '</div>'.
                                        '<div class="message-area" >'.nl2br($oneMsg['message']).'</div>'.
                                    '</div>'.
                                '</div>';

                    $resHtml .= '</div>';
                }
                $resHtml .= '</div></div>';
                echo $resHtml;
            ?>
        </div>

        <div style="position:fixed;bottom:-10px;width:100%;">
            <div class="message-box">
                <div class="card">
                    <div class="card-block">
                        <form action="index.php?page=detail&action=insertMessage&id=<?php echo $id ?>" method="POST" id="formInsertMessage">
                            <div class="row">
                                <div class="form-group">
                                    <div class="col-md-1"><label for="icon" class="col-form-label">アイコン</label></div>
                                    <div class="col-md-11">
                                        <div id="icon-preview">
                                            <img src="<?php echo IMAGE_DIR ?>icon1.png" height="60"/>
                                        </div>
                                        <select name="selIcon" id="selIcon" onchange="iconSelect();">
                                            <?php
                                                for($i = 1;$i <= ICON_MAX_NUMBER; $i++){
                                                    echo "<option value=\"{$i}\">アイコン{$i}</option>";
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group">
                                    <div class="col-md-1"><label for="name" class="col-form-label">名前</label></div>
                                    <div class="col-md-11"><input type="text" class="form-control" name="user_name" id="user_name" maxlength="140" value="匿名" /></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group">
                                    <div class="col-md-1"><label for="message" class="col-form-label">内容</label></div>
                                    <div class="col-md-11"><textarea class="form-control" style="height:120px;" name="message" id="message" maxlength="1024"></textarea></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group">
                                    <div class="col-md-6"><button type="button" onclick="submitMessage();" class="btn btn-success btn-block">投稿する</button></div>
                                    <div class="col-md-6"><button type="button" onclick="closeMessageBox();" class="btn btn-primary btn-block">閉じる</button></div>
                                </div>
                            </div>
                        <form>
                    </div>
                </div>
            </div>
        </div>
        <div style="position:fixed; bottom:-5px;right:-5px;">
            <div onclick="openMessageBox();" class="bg-primary text-white message-open" style="">
                投稿フォームを開く
            </div>
        </div>
    </body>
</html>
