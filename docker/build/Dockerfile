FROM php:7.3-apache
LABEL maintainer="function.op@gmail.com"

# Install packages:
RUN apt-get update && apt-get upgrade -y
RUN apt-get install -y vim nano libzip-dev zip unzip git libssl-dev libcurl4-openssl-dev supervisor wget && rm -rf /var/lib/apt 
RUN pecl install xdebug-3.0.4
# Install php extensions:
RUN docker-php-ext-install bcmath zip opcache && \
	docker-php-ext-enable bcmath zip opcache xdebug

# install composer:
RUN curl -sS https://getcomposer.org/installer | php
RUN chmod +x composer.phar && mv composer.phar /usr/local/bin/composer && \
 	ln -s /usr/local/bin/composer /usr/bin/composer
WORKDIR /

# setup ssh:
RUN apt-get update && apt-get install -y openssh-server
RUN echo 'root:root' | chpasswd
RUN sed -i 's/^#PermitRootLogin.\+/PermitRootLogin yes/' /etc/ssh/sshd_config
RUN mkdir /var/run/sshd && chmod 0755 /var/run/sshd
RUN mkdir -p /root/.ssh/ && touch /root/.ssh/authorized_keys
RUN sed 's@session\s*required\s*pam_loginuid.so@session optional pam_loginuid.so@g' -i /etc/pam.d/sshd

# Setup gd:
RUN apt-get update && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
    && docker-php-ext-install -j$(nproc) iconv \
    && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-install -j$(nproc) gd

# Install mysql driver:
RUN docker-php-ext-install pdo pdo_mysql

# install sqlite:
RUN apt-get install -y sqlite3 libsqlite3-dev

# install chromium for e2e testing:
RUN apt-get install -y libzip-dev chromium
ENV PANTHER_NO_SANDBOX 1

# install platform cli:
RUN composer global require platformsh/cli:3.*
RUN composer global update
RUN ln -s /root/.composer/vendor/platformsh/cli/bin/platform /usr/local/bin/platform

# install intl extension:
RUN apt-get update \
	&& apt-get install -y libicu-dev \
	&& docker-php-ext-configure intl \
	&& docker-php-ext-install intl \
	&& docker-php-ext-enable intl
# install mysqli extension:
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli
RUN mkdir /db
RUN /usr/bin/sqlite3 /db/test.db

# install exif & fileinfo & saop extensions:
RUN apt-get update -y \
  && apt-get install -y \
     libxml2-dev \
  && apt-get clean -y

RUN docker-php-ext-install exif fileinfo soap && docker-php-ext-enable exif fileinfo soap

# add configuration files:
RUN mkdir -p /settings && mkdir -p /var/www/html/public && mkdir -p /backup && cp "$PHP_INI_DIR/php.ini-development" /settings/php.ini
RUN echo 'alias pc="php bin/console"' >> ~/.bashrc
RUN a2enmod rewrite
ADD 000-default.conf /etc/apache2/sites-available/000-default.conf
ADD apache2.conf /etc/apache2/apache2.conf
ADD serve.sh /serve.sh
ADD cache.sh /usr/sbin/cache.sh
ADD config /root/.ssh/
ADD supervisord.conf /etc/supervisor/supervisord.conf
ADD php.ini "$PHP_INI_DIR/php.ini"
RUN chmod +x /serve.sh && chmod +x /usr/sbin/cache.sh

# make xdebug configuration so we can add it later to /usr/local/etc/php/conf.d/xdebug.ini
RUN touch /var/log/xdebug.log && chmod a+rw /var/log/xdebug.log
RUN mkdir -p /config \
    && echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name xdebug.so)" > /config/xdebug-on.ini \
	&& echo "xdebug.mode=debug,develop" >> /config/xdebug-on.ini \
    && echo "xdebug.client_host=host.docker.internal" >> /config/xdebug-on.ini \
    && echo "xdebug.start_with_request=yes" >> /config/xdebug-on.ini \
    && echo 'xdebug.log=/var/log/xdebug.log' >> /config/xdebug-on.ini \
    && echo "xdebug.max_nesting_level=1000" >> /config/xdebug-on.ini \
    && echo 'xdebug.output_dir="/tmp"' >> /config/xdebug-on.ini \
    && echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name xdebug.so)" > /config/xdebug-off.ini \
    && echo "xdebug.mode = off" >> /config/xdebug-off.ini \
    && echo "xdebug.discover_client_host = false" >> /config/xdebug-off.ini \
	&& echo "xdebug.start_with_request = trigger" >> /config/xdebug-off.ini \
	&& echo 'xdebug.log=/var/log/xdebug.log' >> /config/xdebug-off.ini \
    && echo "xdebug.profiler_enable=0" >> /config/xdebug-off.ini \
    && echo "xdebug.max_nesting_level=1000" >> /config/xdebug-off.ini \
    && echo 'xdebug.output_dir="/tmp"' >> /config/xdebug-off.ini \
    && rm -rf /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

WORKDIR /var/www/html
EXPOSE 8000 9003 443 30000 22
VOLUME ["/var/www/html"]
CMD ["/serve.sh"]