<?php
// PHPのエラーレベルを設定 
##すべてオフにするには引数:0
error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED);

// タイムゾーンを指定
date_default_timezone_set('Asia/Tokyo');

// DB有無 1:使う 0:使わない
define(DB_USE, "1");

// MySql or Postgresql
define(DB_NAME, "MySql");
define(HOST_NAME , 'localhost');
define(USER_NAME , 'root');
define(PASSWORD , '198926yasusama');
define(DATABASE , 'poge');
header('Content-Type: text/html; charset=UTF-8');
define(SYSTEM_ROOT , '/home/yasuaki/www/tools.codelike.info/poge');
define(PAGE_TITLE , 'Poge');
//define("SITE_URL","http://tools.codelike.info/poge/");
define("CLASS_FILE_DELIMTER","Ctl");
define("MODEL_FILE_DELIMTER","Mdl");
define("VIEW_FILE_DELIMTER","View");
define("ACTION_DELIMTER","Act");
define("VIEW_DIR","./view/");
define("CSS_DIR","./css/");
define("IMAGE_DIR","./image/");
define("ICON_MAX_NUMBER",12);
define("JS_DIR","./js/");
define(NO_LOGIN_ROOT, "top");
define(LOGIN_ROOT, "main");

//共通クラス・共通部品等読み込み定義
require_once './core/fireSignCtl.php';
require_once './core/fireSignMdl.php';

// 7と5でmysql関連の関数名が違うため判定して、ライブラリを分ける
if(7 <= substr(phpversion(), 0, 1)){
    require_once './lib/mysql7.lib.php';
} else {
    require_once './lib/mysql.lib.php';
}
require_once './lib/pgsql.class.php';
require_once './lib/debug.lib.php';
require_once './lib/mail.lib.php';
require_once './lib/js.lib.php';
