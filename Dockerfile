#syntax=docker/dockerfile:1.4

# Adapted from https://github.com/dunglas/symfony-docker


# Versions
# hadolint ignore=DL3007
FROM dunglas/frankenphp:1-alpine-php8.3 AS frankenphp_upstream
FROM composer/composer:2-bin AS composer_upstream


# The different stages of this Dockerfile are meant to be built into separate images
# https://docs.docker.com/develop/develop-images/multistage-build/#stop-at-a-specific-build-stage
# https://docs.docker.com/compose/compose-file/#target


# Base FrankenPHP image
FROM frankenphp_upstream AS frankenphp_base

WORKDIR /app

# persistent / runtime deps
# hadolint ignore=DL3018
RUN apk add --no-cache \
	acl \
	file \
	gettext \
	git \

	RUN set -eux; \
	install-php-extensions \
	apcu \
	intl \
	opcache \
	zip \
	;

###> recipes ###
###> doctrine/doctrine-bundle ###
RUN set -eux; \
	install-php-extensions pdo_pgsql
###< doctrine/doctrine-bundle ###
###< recipes ###

COPY --link frankenphp/conf.d/app.ini $PHP_INI_DIR/conf.d/
COPY --link --chmod=755 frankenphp/docker-entrypoint.sh /usr/local/bin/docker-entrypoint
COPY --link frankenphp/Caddyfile /etc/caddy/Caddyfile
COPY --link --chmod=755 frankenphp/caddy_linux_amd64 /etc/caddy/caddy

ENTRYPOINT ["docker-entrypoint"]

# https://getcomposer.org/doc/03-cli.md#composer-allow-superuser
ENV COMPOSER_ALLOW_SUPERUSER=1
ENV PATH="${PATH}:/root/.composer/vendor/bin:/etc/caddy"

COPY --from=composer_upstream --link /composer /usr/bin/composer

HEALTHCHECK --start-period=60s CMD curl -f http://localhost:2019/metrics || exit 1
CMD [ "frankenphp", "run", "--config", "/etc/caddy/Caddyfile" ]

# Dev FrankenPHP image
FROM frankenphp_base AS frankenphp_dev

ENV APP_ENV=dev XDEBUG_MODE=off

RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"

RUN set -eux; \
	install-php-extensions \
	xdebug \
	;
###>sql server drivers
RUN curl https://packages.microsoft.com/keys/microsoft.asc | RUN tee /etc/apt/trusted.gpg.d/microsoft.asc

#Download appropriate package for the OS version
#Choose only ONE of the following, corresponding to your OS version

#Debian 12
RUN curl https://packages.microsoft.com/config/debian/12/prod.list | RUN tee /etc/apt/sources.list.d/mssql-release.list

RUN apt-get update
RUN ACCEPT_EULA=Y apt-get install -y msodbcsql18
# optional: for bcp and sqlcmd
RUN ACCEPT_EULA=Y apt-get install -y mssql-tools18
RUN echo 'export PATH="$PATH:/opt/mssql-tools18/bin"' >> ~/.bashrc
RUN source ~/.bashrc
# optional: for unixODBC development headers
RUN apt-get install -y unixodbc-dev
# optional: kerberos library for debian-slim distributions
RUN apt-get install -y libgssapi-krb5-2

RUN pecl install sqlsrv
RUN pecl install pdo_sqlsrv
RUN su
RUN printf "; priority=20\nextension=sqlsrv.so\n" > /etc/php/8.1/mods-available/sqlsrv.ini
RUN printf "; priority=30\nextension=pdo_sqlsrv.so\n" > /etc/php/8.1/mods-available/pdo_sqlsrv.ini
RUN exit
RUN phpenmod sqlsrv pdo_sqlsrv

###>sql server drivers

COPY --link frankenphp/conf.d/app.dev.ini $PHP_INI_DIR/conf.d/

CMD [ "frankenphp", "run", "--config", "/etc/caddy/Caddyfile", "--watch" ]

# Prod FrankenPHP image
FROM frankenphp_base AS frankenphp_prod

ENV APP_ENV=prod
ENV FRANKENPHP_CONFIG="import worker.Caddyfile"

RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

COPY --link frankenphp/conf.d/app.prod.ini $PHP_INI_DIR/conf.d/
COPY --link frankenphp/worker.Caddyfile /etc/caddy/worker.Caddyfile

# prevent the reinstallation of vendors at every changes in the source code
COPY --link composer.* symfony.* ./
RUN set -eux; \
	composer install --no-cache --prefer-dist --no-dev --no-autoloader --no-scripts --no-progress

# copy sources
COPY --link . ./
RUN rm -Rf frankenphp/

RUN set -eux; \
	mkdir -p var/cache var/log; \
	composer dump-autoload --classmap-authoritative --no-dev; \
	composer dump-env prod; \
	composer run-script --no-dev post-install-cmd; \
	chmod +x bin/console; sync;
