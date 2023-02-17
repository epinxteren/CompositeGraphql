.PHONY: deptrac ## [test] Check if there are no cross boundary references
deptrac:deptrac-layered-architecture

.PHONY: deptrac-layered-architecture
deptrac-layered-architecture-gb: ## [test] Check if there are no cross boundary references within layered architecture setup
		$(shell_php) './vendor/bin/deptrac analyse --config-file=deptrac.layered-architecture.yaml --no-cache --report-uncovered'

.PHONY: deptrac-layered-architecture-ci
deptrac-layered-architecture-ci: ## [test]
		$(shell_php) './vendor/bin/deptrac analyse --config-file=deptrac.layered-architecture.yaml --no-cache --report-uncovered || true'
		$(shell_root_php) './vendor/bin/deptrac analyse --config-file=deptrac.layered-architecture.yaml --no-cache --fail-on-uncovered --formatter=junit --output ./junit-report.xml'
