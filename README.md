# SetUp
以下の構築は下記Vagrant環境を前提（その他の環境は適時修正すること）

[Vagrant-web-performance-tuning](https://github.com/hironomiu/Vagrant-web-performance-tuning)
## clone
事前に用意されたディレクトリを削除しcloneする
```
$ rm -Rf web-performance-tuning
$ git clone git@github.com:hironomiu/web-performance-tuning.git
or 
$ git clone https://github.com/hironomiu/web-performance-tuning.git
```

## deploy & DB + Memcache setup 
```
$ make install
```

## browse

http://192.168.56.130

## tips
### DB周りの接続設定
[Vagrant-web-performance-tuning](https://github.com/hironomiu/Vagrant-web-performance-tuning)以外の環境の場合app/config.phpにDB接続(MySQL,Memcached)の設定をすること
```
$ vi app/config.php
```

### BuiltInServerを利用する場合
任意のHOST、PORTを指定して起動
```
$ HOST=xxx.xxx.xxx.xxx PORT=xxxx make server
```
