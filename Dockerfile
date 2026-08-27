# Use the provided PHP-FPM 8.1 image as the base image
FROM registry.autorasa.com/devops/dockerfiles/php-fpm-8.1:latest

# Set the working directory to /var/www/html
WORKDIR /var/www/html

# Install nginx
RUN apt-get update && apt-get install -y nginx php8.1-soap

# Install nginx and required PHP extensions
#RUN apt-get update && apt-get install -y nginx libxml2-dev \
 #   && docker-php-ext-install soap


# Copy the entrypoint script into the container
COPY entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

# Set the correct permissions and ownership for Laravel files
RUN mkdir -p /tmp/nginx/body storage/framework/cache storage/framework/sessions storage/framework/views bootstrap/cache /var/run/nginx/\
    && chown -R www-data:www-data /var/www/html \
    && chmod -R 775 storage bootstrap/cache \
    && chown -R www-data bootstrap/cache &&\
    chown -R www-data /var/www/html &&\
    chown -R www-data /var/lib/nginx &&\
    chown -R www-data /var/run/nginx/


COPY ./docker/nginx/nginx.conf /etc/nginx/nginx.conf
COPY ./docker/php/www.conf /etc/php/8.1/fpm/pool.d/www.conf
COPY ./docker/php/php.ini /etc/php/8.1/fpm/php.ini
COPY --chown=www-data:www-data . .


# Install Composer dependencies
RUN composer install --no-dev --optimize-autoloader \
    && rm -rf /root/.composer;

# USER www-data
    # Set the entrypoint script as the entrypoint
ENTRYPOINT ["/entrypoint.sh"]
