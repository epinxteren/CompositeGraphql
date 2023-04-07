xdebug_ini_file=/usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

.PHONY: xon
xon: ## [utility]
		$(shell_root_php) 'cp -f ${xdebug_ini_file}.disabled ${xdebug_ini_file}'
		make dc-restart-php

.PHONY: xoff
xoff: ## [utility]
		$(shell_root_php) 'rm -f ${xdebug_ini_file}'
		make dc-restart-php
