compose = docker compose \
	-f etc/docker/docker-compose.base.yml \
	-f etc/docker/docker-compose.php.yml

compose += -f etc/docker/docker-compose.development.mount.yml

ifneq ("$(wildcard *etc/docker/docker-compose.override.yml)","")
	compose += -f etc/docker/docker-compose.override.yml
endif

# Using a different name you can have multiple versions of this project running at the same time. Do note that you
# can not have any statically mapped ports in the docker-composer.override.yml file for this to work.
ifndef name
	export COMPOSE_PROJECT_NAME=docker
else
	export COMPOSE_PROJECT_NAME=${name}
	compose += --project-name ${name}
endif

export compose
export compose_tools

shell_php=$(compose) exec  ${extra} php bash -lcs
shell_nginx=$(compose) exec ${extra} nginx bash -lcs
shell_root_php=$(compose) exec --user root:root ${extra} php bash -lcs
php_cli=php -d memory_limit=-1

ifeq ($(LOCAL_MACHINE), yes)
	shell_php=cd php && bash -lc
	shell_root_php=cd php && bash -lc
	# Example: /www-datas/MAMP/bin/php/php8.1.0/bin/php -c "/Library/www-data Support/appsolute/MAMP PRO/conf/php8.1.0.ini"
	php_cli=${PHP8}
endif

symfony_console=${EXTRA_ENV} ${php_cli} ./bin/console

ifdef DEBUG
	symfony_console=XDEBUG_SESSION=1  ${EXTRA_ENV} ${php_cli} ./bin/console
endif

export shell_php
export shell_nginx
export shell_root_php
export php_cli
export DOCKER_MACHINE

.PHONY: all

.PHONY: sh
sh: ## [utility]
		$(compose) exec  php bash -l

.PHONY: sh-root
sh-root: ## [utility]
		$(compose) exec --user root:root php bash -l


.PHONY: sh-nginx
sh-nginx: ## [utility]
		$(compose) exec nginx sh -l
