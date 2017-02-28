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
                        <div class="card-header">エラー</div>
                        <div class="card-block">
                            <?php echo $error ?><br /><br />
                            <?php echo $returnTag ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
