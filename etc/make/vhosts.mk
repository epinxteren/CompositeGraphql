.PHONY: hosts-add
hosts-add: ## [internal] Add vhost to your local system
		./etc/scripts/vhost.sh addhost

.PHONY: hosts-remove
hosts-remove: ## [internal] remove vhost to your local system
		./etc/scripts/vhost.sh removehost

.PHONY: install-mkcert-gp
install-mkcert-gp: ## [internal] Install makecrt tool. not required anymore.
		# brew install mkcert

.PHONY: install-development-certificates
install-development-certificates: ## [internal] Install self-signed development certificates.
		./etc/scripts/install_development_certificates.sh
