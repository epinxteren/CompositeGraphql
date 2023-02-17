.PHONY: phpmd
phpmd: ## [test]
		$(shell_php) '${php_cli} ./vendor/bin/phpmd src ansi ./phpmd.xml'

