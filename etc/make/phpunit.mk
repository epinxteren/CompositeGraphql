.PHONY: phpunit
phpunit: ## [test]
		$(shell_php) "${php_cli} ./vendor/bin/phpunit --order-by=defects --stop-on-failure"
