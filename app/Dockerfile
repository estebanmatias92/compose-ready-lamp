# Base Stage: Installs common dependencies and performs basic configurations
FROM php:8.1-apache as base

# General configurations and necessary packages
RUN apt-get update && apt-get install -y --no-install-recommends \
    libzip-dev \
    zip \
    && docker-php-ext-install zip pdo pdo_mysql \
    && a2enmod rewrite \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Set custom Apache Document Root
ENV APACHE_DOCUMENT_ROOT=/var/www/html
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf \
    && sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Copy the source code (ensure a proper .dockerignore is used)
COPY . /var/www/html
WORKDIR /var/www/html



# Composer Stage: Installs Composer for use in other stages
FROM composer:2.4 as composer
COPY --from=base /var/www/html /var/www/html
WORKDIR /var/www/html
RUN composer install \
    --no-dev \
    --optimize-autoloader \
    --ignore-platform-reqs \
    --no-interaction \
    --no-plugins \
    --no-scripts \
    --prefer-dist



# Development Stage
FROM base as development

# Install development tools like Git and Xdebug
RUN apt-get update && apt-get install -y --no-install-recommends \
    git \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Copy Composer and vendor dependencies
COPY --from=composer /var/www/html/vendor /var/www/html/vendor

# Copy and execute the user setup script
COPY scripts/setup-dev-user.sh /usr/local/bin/setup-dev-user.sh
RUN chmod +x /usr/local/bin/setup-dev-user.sh \
    && /usr/local/bin/setup-dev-user.sh developer developer

# Switch to the non-root user
USER developer



# Production Stage
FROM base as production

# Copy dependencies from Composer
COPY --from=composer /var/www/html/vendor /var/www/html/vendor

ENTRYPOINT ["apache2-foreground"]
