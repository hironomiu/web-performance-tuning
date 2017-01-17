PHP?=$(shell which php)
ZCAT?=$(shell which zcat)
GZIP?=$(shell which gzip)
MYSQL?=$(shell which mysql)
MYSQLDUMP?=$(shell which mysqldump)
CP?=$(shell which cp)
CHMOD?=$(shell which chmod)
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
	$(CHMOD) 775 src/cache

front-setup:
	$(NPM) install
	$(BOWER) install

db-setup:
	$(ZCAT) ddl/users.dump.gz | $(MYSQL) -u$(DB_USER) -p$(DB_PASS) $(DB_SCHEMA)
	$(ZCAT) ddl/messages.dump.gz | $(MYSQL) -u$(DB_USER) -p$(DB_PASS) $(DB_SCHEMA)
	$(ZCAT) ddl/follows.dump.gz | $(MYSQL) -u$(DB_USER) -p$(DB_PASS) $(DB_SCHEMA)
	$(ZCAT) ddl/user_birth_month_count.dump.gz | $(MYSQL) -u$(DB_USER) -p$(DB_PASS) $(DB_SCHEMA)

memcache-setup:
	$(PHP) src/setup/setup_memcache.php

install: php-setup config-setup front-setup db-setup memcache-setup

server:
	$(PHP) -S $(HOST):$(PORT) -t ./public_html

db-backup:
	$(MYSQLDUMP) -u$(DB_USER) $(DB_SCHEMA) users -p$(DB_PASS) | $(GZIP) > ddl/users.dump.gz
	$(MYSQLDUMP) -u$(DB_USER) $(DB_SCHEMA) messages -p$(DB_PASS) | $(GZIP) > ddl/messages.dump.gz
	$(MYSQLDUMP) -u$(DB_USER) $(DB_SCHEMA) follows -p$(DB_PASS) | $(GZIP) > ddl/follows.dump.gz
	$(MYSQLDUMP) -u$(DB_USER) $(DB_SCHEMA) user_birth_month_count -p$(DB_PASS) | $(GZIP) > ddl/user_birth_month_count.dump.gz

