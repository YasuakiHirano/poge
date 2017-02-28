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
                        <div class="card-header">掲示板を新規作成する</div>
                        <div class="card-block">
                            <form action="index.php?page=createBoard&action=makeBoard" method="POST" id="formMakeBoard">
                               <div class="form-group">
                                    <label for="icon" class="col-form-label">アイコン</label>
                                    <div class="col-10">
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
                                 <div class="form-group">
                                    <label for="board_title" class="col-2 col-form-label">タイトル</label>
                                    <div class="col-10">
                                        <input type="text" class="form-control" name="board_title" id="board_title" maxlength="140"/>
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <label for="user_name" class="col-form-label">名前</label>
                                    <div class="col-10"><input type="text" class="form-control" name="user_name" id="user_name"  maxlength="140" /></div>
                                  </div>
                                  <div class="form-group">
                                    <label for="about_text" class="col-2 col-form-label">説明文</label>
                                    <div class="col-10">
                                        <textarea class="form-control" style="height:200px;" name="about_text" id="about_text" maxlength="1024"></textarea>
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <label for="password" class="col-2 col-form-label">パスワード</label>
                                    <div class="col-10">
                                        <input type="password" class="form-control" name="password" id="password" maxlength="20" />
                                    </div>
                                  </div>
                                  <button type="button" onclick="submitBoard();" class="btn btn-success btn-block">作成</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
