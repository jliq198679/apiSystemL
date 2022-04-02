FROM php:7.4-fpm

RUN rm /etc/apt/preferences.d/no-debian-php

RUN apt-get update && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
        php-cli   \
        php-mysql \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd


ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

RUN chmod +x /usr/local/bin/install-php-extensions && \
    install-php-extensions mongodb intl soap bcmath mysqli amqp ldap zip xmlrpc gmp redis-stable xdebug pdo_mysql


# Set working directory
WORKDIR /var/www/apiSystem

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*


# Install composer (php package manager)
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Add user for laravel application
RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

COPY . /var/www/apiSystem/

# Copy existing application directory permissions
COPY --chown=www:www . /var/www/apiSystem

# Change current user to www
USER www

# Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"]
