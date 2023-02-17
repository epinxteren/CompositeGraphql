.PHONY: composer-update
composer-update: ## [utility] Update Composer dependencies.
		$(shell_php) 'COMPOSER_MEMORY_LIMIT=-1 composer update'

.PHONY: composer-install
composer-install: ## [utility] Install Composer dependencies.
		$(shell_php) 'COMPOSER_MEMORY_LIMIT=-1 composer install'

.PHONY: composer-update-lock
composer-update-lock: ## [utility] Update Composer lock file after merge conflict resolution.
		$(shell_php) 'COMPOSER_MEMORY_LIMIT=-1 composer update --lock'

.PHONY: composer-validate
composer-validate: ## [utility] Validate composer.json and composer.lock files.
		$(shell_php) 'COMPOSER_MEMORY_LIMIT=-1 composer validate --no-check-all --no-check-publish'
		$(shell_php) 'COMPOSER_MEMORY_LIMIT=-1 composer install --dry-run'
