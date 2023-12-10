# The base image for the container 
FROM php:8.1-apache as base
# Values for Document Root path
#ARG APACHE_DOCUMENT_ROOT=/var/www/html
ENV APACHE_DOCUMENT_ROOT=${APACHE_DOCUMENT_ROOT:-/var/www/html}
# Install PHP tools (composer, xdebug)
COPY --from=composer:2.4 /usr/bin/composer /usr/bin/composer
# Change the Document Root for Apache
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf \
    && sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf
# Install extensions for PHP
RUN docker-php-ext-install pdo pdo_mysql


#
# Development dependencies
#
FROM base as devdeps
# Install dev tools
RUN apt-get update && apt-get install -y --no-install-recommends \
    git \
    && apt-get clean
# Install Docker tools (cli, buildx, compose) 
COPY --from=gloursdocker/docker / /


#
# Builder stage for Runtime
#     
FROM base as builder
# Set this if you use composer as super user at all times like in docker containers
#ENV COMPOSER_ALLOW_SUPERUSER=1
WORKDIR /app
# Pull the package files
COPY ./composer.* .
# Install everything
RUN composer install \
    --ignore-platform-reqs \
    --no-interaction \
    --no-plugins \
    --no-scripts \
    --prefer-dist


#
# VS Code Stage 
# (This is preferred to run as a Docker Dev Environment)
#
FROM devdeps as development
# Modifyble through cli args
ARG USER="vscode"
# Create and change user
RUN useradd -s /bin/bash -m $USER \
    && groupadd docker \
    && usermod -aG docker $USER
USER $USER
# Replace the host SSH exe with the WSL distro SSH exe
#RUN git config --global --replace-all core.sshCommand "/usr/bin/ssh"


#
# Production Target Stage 
# Normally called without specifying "target" in compose
#
FROM base as production

WORKDIR /var/www/html

COPY --from=builder /app/vendor .
COPY . .

USER www-data

CMD ["apache2-foreground"]