#!/bin/sh
set -e

# Check if a command is provided as an argument
if [ "$1" ]; then
    # Execute the provided command
    exec "$@"
else
    # Default command to run if no command is provided
    echo "No command provided. Going into default lemp mode"
    # mkdir -p /var/www/html/storage/framework/cache
    # chmod 777 -R /var/www/html/storage/framework/cache
    # chmod 775 -R /var/www/html/storage/
    # chown -R www-data:www-data /var/www/html/storage/framework/cache
    # chmod 775 -R /var/www/html/storage/app/purifier
    php-fpm8.1
    chown -R www-data /var/www/html/storage/
    nginx
fi
