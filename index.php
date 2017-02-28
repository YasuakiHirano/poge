<?php
    session_start();
    require_once './config.php';
    require_once './dispatcher.php';

    $default_page = NO_LOGIN_ROOT;
    $default_action = LOGIN_ROOT;
    $dispatcher = new Dispatcher();
    $dispatcher->setSystemRoot(SYSTEM_ROOT);

    if($_SESSION["login_user"] == "" && $_SESSION["login_id"] == "")
    {
        //ログインしていない場合:index.phpのデフォルト設定
        if($_GET['page'] == NULL)
        {
            $_GET['page'] = $default_page;
        }
        if($_GET['action'] == NULL)
        {
            $_GET['action'] = $default_action;
        }
    }
    else
    {
        //ログイン済みの場合:index.phpのデフォルト設定
        if($_GET['page'] == NULL)
        {
            $_GET['page'] = "loginAfter";
        }
        if($_GET['action'] == NULL)
        {
            $_GET['action'] = "main";
        }
    }
 
    $dispatcher->dispatch();
