# Don't add symfony commands, symfony can be broken.

.PHONY: cache-clear
cache-clear:
		$(shell_root_php) 'rm -fr /tmp/cache \
		&& mkdir -p /tmp/qa /app/var /tmp/cache /opt/.phpstorm_helpers/ \
		&& chmod -R 777 /tmp/qa /app/var /tmp/cache /opt/.phpstorm_helpers/'


