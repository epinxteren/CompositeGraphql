.PHONY: php-cs-validate
php-cs-validate: ## [test]
		$(shell_root_php) '${php_cli} ./vendor/bin/php-cs-fixer.phar fix --config=.php-cs-fixer.php --dry-run'

.PHONY: php-cs-fix
php-cs-fix: ## [test]
		$(shell_root_php) '${php_cli} ./vendor/bin/php-cs-fixer.phar fix --config=.php-cs-fixer.php -vv --allow-risky=yes'
