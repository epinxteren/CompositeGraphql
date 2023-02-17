### README ###
# The comments behind recipes with two octothorpes (#) are used by the "help" recipe ($ make help) to print descriptions
# next to the available commands.
ifneq (,$(wildcard .env.generated))
include .env.generated
export $(shell sed 's/=.*//' .env.generated)
$(info .env.generated loaded)
endif

ifneq (,$(wildcard .env))
include .env
export $(shell sed 's/=.*//' .env)
$(info .env loaded)
endif

include etc/make/index.mk

.PHONY: help
help: ## Display this help message. Messages marked with "[internal]" are primarily used internally and are of limited use - only use them if you know what you're doing
	@cat $(MAKEFILE_LIST) | grep -e "^[a-zA-Z_\-]*: *.*## *" | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-40s\033[0m %s\n", $$1, $$2}'

.PHONY: first-time-start # Start for first time (Installs vendor packages etc)
first-time-start: hosts-add copy-files dc-build dc-start cache-clear composer-install dc-dump## Start the environment for the first time. Do not use to rebuild the environment.

