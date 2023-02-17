.PHONY: dc
dc: ## [utility] Run compose command make command=ps compose
		$(compose) $(command)

.PHONY: dc-combined
dc-combined: ## [utility] See combined docker compose files with resolve environment variables.
		$(compose) convert

.PHONY: dc-inspect
dc-inspect: ## [utility] See combined docker compose files with resolve environment variables.
		$(compose) inspect

.PHONY: dc-dump
dc-dump: ## [utility] Create combined docker compose file for quick reference inside the IDE.
		rm etc/docker/docker-compose.yml || true
		$(compose) convert > etc/docker/docker-compose.yml

.PHONY: dc-restart-php
dc-restart-php: ## [utility]
		$(compose) restart php

.PHONY: dc-restart
dc-restart: ## [utility] Restart all services or a specific service s=php.
		$(compose) restart  $(s)

.PHONY: dc-start
dc-start: ## [utility] Spin up environment.
		$(compose) up -d --remove-orphans

.PHONY: dc-stop
dc-stop: ## [utility] Stop all services or a specific service s=php.
		$(compose) stop $(s)

.PHONY: dc-ps
dc-ps: ## [utility] Show all services or a specific service s=php.
		$(compose) ps $(s)

.PHONY: dc-rebuild
dc-rebuild: dc-erase ## [utility] Rebuilding the containers
		$(compose) pull
		$(compose) build --progress plain

.PHONY: dc-rebuild-start
dc-rebuild-start: dc-rebuild dc-start ## [utility] Rebuilding the containers and directly starting them

.PHONY: dc-rs
dc-rs: dc-rebuild-start ## [utility] short alias for dc-rebuild-start

.PHONY: dc-erase
dc-erase: ## [utility] Stop and delete containers, clean volumes.
		$(compose) stop
		$(compose) rm -v -f

.PHONY: dc-build
dc-build: dc-build-gb dc-build-cb ## [internal] Build environment.


.PHONY: dc-build-gb
dc-build-gb:
		echo $(compose)
		$(compose) build --parallel

.PHONY: dc-build-cb
dc-build-cb:
		$(compose) build --parallel

.PHONY: dc-tag-builds
dc-tag-builds: ## [utility] Create build for ci target=test or target=prod. You should predefine CLIENTBOX_IMAGE and GROWTHBASE_IMAGE tags.
		docker build --tag $$CLIENTBOX_IMAGE --target ${target} .
		cd growthbase
		docker build --tag $$GROWTHBASE_IMAGE --target ${target} .
