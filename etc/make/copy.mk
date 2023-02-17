## [internal]
.PHONY: copy-files
copy-files: copy-default-docker-compose-file

## [internal] Copy default compose file
.PHONY: copy-default-docker-compose-file
copy-default-docker-compose-file:
		cp -n ./etc/docker/docker-compose.override.example.yml etc/docker/docker-compose.override.yml || true
