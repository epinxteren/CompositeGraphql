.PHONY: phpunit
phpunit: ## [test]
		$(shell_php) "APP_ENV=test ${symfony_console} cache:clear --no-warmup"
		$(shell_php) "${php_cli} ./vendor/bin/phpunit --order-by=defects --stop-on-failure"
