PHP?=$(shell which php)
ZCAT?=$(shell which zcat)
GZIP?=$(shell which gzip)
MYSQL?=$(shell which mysql)
MYSQLDUMP?=$(shell which mysqldump)
CP?=$(shell which cp)
DB_USER?=root
DB_PASS?=vagrant
DB_SCHEMA?=groupwork
HOST?=localhost
PORT?=8888
NPM?=$(shell which npm)
BOWER?=$(shell pwd)/node_modules/bower/bin/bower

php-setup:
	$(PHP) -r "eval('?>'.file_get_contents('https://getcomposer.org/installer'));"
	$(PHP) composer.phar install

config-setup:
	$(CP) src/config.php.template src/config.php

front-setup:
	$(NPM) install
	$(BOWER) install

db-setup:
	$(ZCAT) ddl/user.dump.gz | $(MYSQL) -u$(DB_USER) -p$(DB_PASS) $(DB_SCHEMA)
	$(ZCAT) ddl/message.dump.gz | $(MYSQL) -u$(DB_USER) -p$(DB_PASS) $(DB_SCHEMA)
	$(ZCAT) ddl/follows.dump.gz | $(MYSQL) -u$(DB_USER) -p$(DB_PASS) $(DB_SCHEMA)

memcache-setup:
	$(PHP) src/setup/setup_memcache.php

install: php-setup config-setup front-setup db-setup memcache-setup

server:
	$(PHP) -S $(HOST):$(PORT) -t ./public_html

db-backup:
	$(MYSQLDUMP) -u$(DB_USER) $(DB_SCHEMA) user -p$(DB_PASS) | $(GZIP) > ddl/user.dump.gz
	$(MYSQLDUMP) -u$(DB_USER) $(DB_SCHEMA) message -p$(DB_PASS) | $(GZIP) > ddl/message.dump.gz
	$(MYSQLDUMP) -u$(DB_USER) $(DB_SCHEMA) follows -p$(DB_PASS) | $(GZIP) > ddl/follows.dump.gz

