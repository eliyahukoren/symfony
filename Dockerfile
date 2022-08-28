FROM php:7.4-apache

RUN a2enmod rewrite
########################################################################################################################
# Defaults
########################################################################################################################
RUN apt-get update && apt-get install apt-file -y && apt-file update && apt-get install vim -y\
    && apt-get install -y libzip-dev git wget --no-install-recommends \
    && apt-get clean && apt-get install -y default-mysql-client \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

RUN docker-php-ext-install pdo mysqli pdo_mysql zip;

# disable default site
RUN a2dissite 000-default.conf
########################################################################################################################
# Install Symfony CLI
########################################################################################################################
RUN curl -1sLf 'https://dl.cloudsmith.io/public/symfony/stable/setup.deb.sh' | bash
RUN apt install symfony-cli


########################################################################################################################
# Installing phpmyadmin
########################################################################################################################
RUN apt update && \
wget https://files.phpmyadmin.net/phpMyAdmin/5.2.0/phpMyAdmin-5.2.0-all-languages.tar.gz && \
tar xvf phpMyAdmin-5.2.0-all-languages.tar.gz && \
mv phpMyAdmin-5.2.0-all-languages/ /usr/share/phpmyadmin && \
mkdir -p /var/lib/phpmyadmin/tmp && \
chown -R www-data:www-data /var/lib/phpmyadmin

COPY docker/config.inc.php /usr/share/phpmyadmin/config.inc.php
COPY docker/phpmyadmin.conf /etc/apache2/conf-available/phpmyadmin.conf
RUN a2enconf phpmyadmin.conf

COPY docker/symfony.ett.local.conf /etc/apache2/sites-enabled/symfony.ett.local.conf
COPY docker/entrypoint.sh /entrypoint.sh
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

RUN chmod +x /entrypoint.sh
CMD ["apache2-foreground"]
ENTRYPOINT ["/entrypoint.sh"]
