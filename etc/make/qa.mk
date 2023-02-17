.PHONY: pre-push
pre-push: php-cs-validate phpmd phpstan deptrac phpunit ## [test] Validate tests, lints and code style.

.PHONY: pre-commit
pre-commit: php-cs-fix pre-push ## [test]

