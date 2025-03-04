#!/bin/bash

# Set the web server user (usually www-data)
WEBUSER="www-data"

# Set directory permissions
sudo chown -R $USER:$WEBUSER .
sudo find . -type f -exec chmod 664 {} \;
sudo find . -type d -exec chmod 775 {} \;

# Set specific permissions for storage and bootstrap/cache
sudo chown -R $WEBUSER:$WEBUSER storage
sudo chown -R $WEBUSER:$WEBUSER bootstrap/cache
sudo chmod -R 775 storage
sudo chmod -R 775 bootstrap/cache

# Make artisan executable
sudo chmod +x artisan

echo "Permissions have been set!"
