# SetUp
以下の構築は下記Vagrant環境を前提（その他の環境は適時修正すること）

[Vagrant-CentOS7](https://github.com/hironomiu/Vagrant-CentOS7)
## clone
事前に用意されたディレクトリを削除しcloneする
```
$ rm -Rf web-performance-tuning
$ git clone git@github.com:hironomiu/web-performance-tuning.git web-performance-tuning
or 
$ git clone https://github.com/hironomiu/web-performance-tuning.git web-performance-tuning
```

## deploy & DB 
```
$ make install
```


## tips
### DB周りの接続設定
app/config.phpにDB接続(MySQL,Memcached)の設定をすること
```
$ vi app/config.php
```

### BuiltInServerを利用する場合
任意のHOST、PORTを指定して起動
```
$ HOST=xxx.xxx.xxx.xxx PORT=xxxx make server
```

### cacheディレクトリのパーミッション
src/cacheはWebサーバが書き込み可能な状態にすること
