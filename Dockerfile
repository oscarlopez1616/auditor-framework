# composer dependencies. WORKDIR id /var/www/source
FROM auditorframework/php:7.3.9-fpm

ARG NAMESPACE
ARG APPLICATION_NAME

WORKDIR /var/www/${NAMESPACE}-${APPLICATION_NAME}

COPY composer.json composer.json
COPY composer.lock composer.lock
COPY symfony.lock symfony.lock

RUN composer install --no-autoloader --no-scripts --prefer-dist --no-progress --no-suggest

COPY .env.dist .env.dist
COPY phpunit.xml.dist phpunit.xml.dist
COPY src src
COPY bin bin
COPY App App
COPY public public
COPY config config
COPY build.gradle build.gradle
COPY other.gradle other.gradle
COPY gradlew gradlew
COPY gradle gradle
COPY gradlew.bat gradlew.bat
COPY etc/ansible .

RUN composer dump-autoload --optimize --classmap-authoritative
RUN composer install

RUN \
    mkdir -p var \
    && chown -R www-data: /var/www

RUN adduser www-data root

RUN ./gradlew tasks

COPY start.sh start.sh

ENTRYPOINT ["./start.sh"]
