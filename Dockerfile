FROM php:7.4-apache

RUN a2enmod rewrite

RUN apt-get update \
    && apt-get install -y libzip-dev git wget --no-install-recommends \
    && apt-get clean && apt-get install -y default-mysql-client \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

RUN docker-php-ext-install pdo mysqli pdo_mysql zip;

# disable default site
RUN a2dissite 000-default.conf
COPY docker/symfony.ett.local.conf /etc/apache2/sites-enabled/symfony.ett.local.conf
# COPY docker/entrypoint.sh /entrypoint.sh
COPY ./symphart /var/www/html

# WORKDIR /var/www/html
WORKDIR /var/www/html/symphart

########################################################################################################################
# Installing composer
########################################################################################################################
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN chmod +x /usr/bin/composer
ENV COMPOSER_ALLOW_SUPERUSER 1

WORKDIR /var/www/html/symphart
RUN composer install -n

# RUN chmod +x /entrypoint.sh
CMD ["apache2-foreground"]
# ENTRYPOINT ["/entrypoint.sh"]
