FROM webdevops/php-apache:8.1


WORKDIR /app
# copy all project files to container
COPY app/ app/
COPY bootstrap/ bootstrap/
COPY config/ config/
COPY database/ database/
COPY public/ public/
COPY resources/ resources/
COPY routes/ routes/
COPY tests/ tests/
COPY .env .env
COPY .htaccess .htaccess
COPY composer.json composer.json
COPY composer.lock composer.lock
# COPY laravel-echo-server.json laravel-echo-server.json
COPY server.php server.php
COPY artisan artisan
COPY vendor/ vendor/
COPY storage/ storage/
# run composer install
RUN composer install
# make supervisor commands exutable
# COPY .docker/supervisor/*.sh /supervisor/
# RUN chmod +x /supervisor/*.sh
# make storage if not exists
RUN mkdir -p storage
# give permissions full access for storage , logs , cache
RUN chmod -R 777 storage/logs
RUN chmod -R 777  bootstrap/cache
RUN chmod -R 777 storage/framework/sessions
RUN chmod -R 777 storage/framework/views
# enable rewrite mode
RUN a2enmod rewrite
# clear cache and class autoload
RUN php artisan optimize:clear
RUN composer dump-autoload
# copy supervisor configs to container
# COPY .docker/supervisor/*.conf /opt/docker/etc/supervisor.d/
