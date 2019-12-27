FROM php:7.3.9-fpm
ARG TIMEZONE

ENV RMQ_VERSION v3.7.15
ENV XDEBUG_VERSION xdebug-2.7.2

#in order to install soap, provisional fix
RUN rm /etc/apt/preferences.d/no-debian-php
RUN apt-get update && apt-get install -y git unzip openssl procps acl libzip-dev libsodium-dev libxml2-dev php-soap

#install python and rabbitmqadmin
RUN apt install -y python3
RUN apt install -y python-mysqldb
RUN apt install -y python-pip
RUN pip install requests
RUN pip install PyMySQL

RUN curl https://raw.githubusercontent.com/rabbitmq/rabbitmq-management/${RMQ_VERSION}/bin/rabbitmqadmin > /usr/local/bin/rabbitmqadmin \
    && chmod +x /usr/local/bin/rabbitmqadmin

#install ansible
RUN apt install -y ansible

# Install java
RUN mkdir -p /usr/share/man/man1
RUN apt install default-jre -y

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer --version

# Install some dependencies
RUN apt install wkhtmltopdf -y
RUN apt install xvfb -y

# Set timezone
RUN ln -snf /usr/share/zoneinfo/${TIMEZONE} /etc/localtime && echo ${TIMEZONE} > /etc/timezone
RUN printf '[PHP]\ndate.timezone = "%s"\n', ${TIMEZONE} > /usr/local/etc/php/conf.d/tzone.ini

# Install extensions
RUN docker-php-ext-install pdo pdo_mysql bcmath zip sodium soap

# Install Redis extension
RUN pecl install -o -f redis && rm -rf /tmp/pear && docker-php-ext-enable redis

# Install xdebug
RUN pecl install ${XDEBUG_VERSION} && docker-php-ext-enable xdebug
RUN echo 'xdebug.remote_port=9000' >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo 'xdebug.remote_enable=1' >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo 'xdebug.remote_connect_back=1' >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo 'xdebug.idekey="phpstorm"' >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

# Install Node ant others
RUN curl -sL https://deb.nodesource.com/setup_8.x | bash -
RUN apt-get install -y nodejs

RUN curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | apt-key add -
RUN echo "deb https://dl.yarnpkg.com/debian/ stable main" | tee /etc/apt/sources.list.d/yarn.list

RUN apt-get update && apt-get install yarn && apt-get install npm -y

RUN npm install -g newman

# Create an alias for Symfony console
RUN echo 'alias symfony="php bin/console"' >> ~/.bashrc

RUN chown www-data /var/www/

WORKDIR /var/www/symfony


