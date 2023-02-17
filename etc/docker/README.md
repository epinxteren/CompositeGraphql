# Docker (Compose) information

There is a makefile at the repository root which makes managing the development environment much easier.

## Development Proxy

Consult the Techfarm Proxy project for more information, as the proxy is technically out of scope for Clientbox.

## Compose configuration & commands

The Docker Compose configuration is split into multiple files. Normally when you want to use multiple files for Docker
Compose you have to add an "-f" argument for each YAML file, which becomes increasingly annoying especially as the
amount of configuration files grows.

It is possible to use environment variables to (statically) specify the Compose files to each for each Docker Compose
command. For an example configuration see `.env.example` (in the project root).

-   docker-compose.base.yml: Common shared services.
-   docker-compose.clientbox.yml: Clientbox specific www-data services.
-   docker-compose.growthbase.yml: Growthbase specific www-data services.
-   docker-compose.development.yml: Development configuration for mounts are docker image references.
-   docker-compose.docker-prod.yml: Run in production mode without docker mounts.
-   docker-compose.docker-test.yml: Run in test mode without docker mounts.
-   docker-compose.env.yml: Run from exiting images without docker mounts.
-   docker-compose.override.example.yml: Your local configuration for exposing ports to the hosts system.

### Docker Compose override file

A Docker Compose override file allows you to override or append services, options, environment variables etc. This
allows you to, for example, map a port to your host machine so you can access the MySQL container.

**Note:** Docker Compose merges all configuration files, meaning that not everything is possible e.g. removing an
element from a list such as a volume. Check the
["Adding and overriding configuration" section on the Docker documentation website](https://docs.docker.com/compose/extends/#adding-and-overriding-configuration)
for more information

Please consult the `docker-compose.override.example.yml` file for more information about Docker Compose overrides.

To verify if everything works correctly you dump the complete docker-compose.yml file with:

```bash
make dc-dump

# or for a print to screen only:

make compose-combined
```
