ARG PHP_VERSION=latest
FROM php:${PHP_VERSION}

# Update sources.list to use archive.debian.org for Debian Buster.
RUN if [ "$(cat /etc/os-release | grep VERSION_CODENAME | cut -d'=' -f2)" = "buster" ]; then \
        sed -i 's/deb.debian.org/archive.debian.org/g' /etc/apt/sources.list && \
        sed -i 's/security.debian.org/archive.debian.org/g' /etc/apt/sources.list && \
        sed -i '/.*-updates.*/d' /etc/apt/sources.list; \
    fi

RUN apt-get update && apt-get install -y git unzip && rm -rf /var/lib/apt/lists/*
COPY --from=composer:2.2 /usr/bin/composer /usr/bin/composer

WORKDIR /code

COPY composer.json composer.json
RUN composer install

COPY . .
