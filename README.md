#pogeとは
レスポンシブな掲示板です。  
シンプルで簡単に設定できるものを目指しました。  
PHPの復習ついでに作成してみました。  
  
###動作環境
下記で動作します。mysql接続等の関数名が変わっていたため、7に合わせて書きました。  
今のところPHP5以下には対応してないです。  
MySql  
PHP7  
Apache or nginx  
  
###設置方法
設置したいディレクトリに下記コマンドで取得  
```
wget https://github.com/YasuakiHirano/poge/archive/master.zip  
```
  
展開
```
unzip master.zip  
```
  
下記で展開したディレクトリに移動しますが  
必要な場合はディレクトリ名を変更してください  
```
cd poge-master
```
  
コマンドで設定できます。下記のコマンドを使います。  
DB情報・配置ディレクトリのパス・ページ名を入力し、config.phpを書き換えます。  
手動で書き換えても設定可能です。  
```
./console setboard  
```
