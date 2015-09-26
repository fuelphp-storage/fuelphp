# This is only intended for a development environment and should most likely not be used for acutally
# deploying applications, you have been warned!

FROM php:7.0-apache
MAINTAINER team@fuelphp.com

# Make sure mbstring is installed, composer needs this
RUN docker-php-ext-install mbstring

# Copy over the apache config to enable the app's vhost
ADD default.conf /etc/apache2/sites-enabled/000-default.conf

# Make sure our files exist
RUN mkdir -p /var/www
WORKDIR /var/www
ADD . ./

# Composer install
RUN curl -sS https://getcomposer.org/installer | php
RUN ./composer.phar install

# Make the config and log dirs writable
RUN chmod 0777 /var/www/components/demo/logs

# This can be used to set your fuel environment
# This can be overriden when the container runs by using `-e 'FUEL_ENV=something_else`
ENV FUEL_ENV development

# Start apache and expose port 80
RUN service apache2 start
EXPOSE 80

