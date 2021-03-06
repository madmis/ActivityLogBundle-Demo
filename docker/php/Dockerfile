FROM php:7-fpm

#+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
ENV DEBIAN_FRONTEND noninteractive
RUN TERM=xterm
#+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

#+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
RUN echo 'PS1="\[\033[36m\]\u\[\033[m\]@\[\033[95;1m\]docker-php:\[\033[34m\]\w\[\033[m\]\$ "' >> ~/.bashrc
#+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

#+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
RUN apt-get update && apt-get install -y \
    vim \
    wget \
    git \
    libpq-dev \
    libzip-dev \
    libicu-dev \
    libpng12-dev \
    libjpeg-dev \
    libmcrypt-dev \
    libxml2-dev \
    libsqlite3-dev

RUN rm -rf /var/lib/apt/lists/* \
	&& docker-php-ext-configure gd --with-png-dir=/usr --with-jpeg-dir=/usr \
	&& docker-php-ext-install \
	    bcmath \
	    ctype \
	    dom \
	    gettext \
	    json \
	    gd \
	    mcrypt \
	    mbstring \
	    opcache \
	    pdo \
	    pdo_pgsql \
	    pgsql \
	    zip \
        sockets \
        intl \
        simplexml \
        xml \
        zip

#+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

#+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
RUN usermod -a -G root www-data
RUN usermod -u 1000 www-data
#+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

#+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
RUN php -r "readfile('https://getcomposer.org/installer');" | php && chmod +x composer.phar && mv composer.phar /usr/local/bin/composer
RUN composer config -g github-oauth.github.com ce3c9b19dc7d59ef066961f3ddc4a1ea2d52126e

RUN export PATH="~/.composer/vendor/bin/:$PATH"
#+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

#+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && echo "xdebug.remote_enable=1" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.remote_autostart=0" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.remote_connect_back=1" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.remote_port=9000" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "debug.remote_handler=dbgp" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

#+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

#+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
COPY app.conf /usr/local/etc/php/php.ini
COPY pool.app.conf /usr/local/etc/php-fpm.d/
#+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

RUN apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

WORKDIR /var/www

RUN setfacl -R -m u:"www-data":rwX /var/www
RUN setfacl -dR -m u:"www-data":rwX /var/www