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
                        <div class="card-header"><?php echo $messageTitle ?></div>
                        <div class="card-block">
                            <?php echo $message ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
