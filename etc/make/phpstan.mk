.PHONY: phpstan
phpstan: ## [test]
		$(shell_root_php) '${php_cli} ./vendor/bin/phpstan analyse'

.PHONY: phpstan-cache-clear
phpstan-cache-clear:
		$(shell_root_php) 'rm -fr /tmp/qa/phpstan'

