FROM php:8.3-fpm-alpine

# Set build arguments
ARG USER_ID
ARG GROUP_ID
ARG USER

# Create a group and user
RUN addgroup -g ${GROUP_ID} -S ${USER} && adduser -u ${USER_ID} -S ${USER} -G ${USER}

# Set the working directory
WORKDIR /var/www/html

# Useful PHP extension installer image, copy binary into your container
COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/

# Install php extensions
RUN set -eux && /usr/local/bin/install-php-extensions pdo pdo_mysql

# obtain composer using multi-stage build
COPY --from=composer:2.4 /usr/bin/composer /usr/bin/composer

# Additional extensions and configurations can be added here

# Switch to the created user
USER ${USER}
