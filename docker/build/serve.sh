#!/bin/bash

ENABLE_XDEBUG=${ENABLE_XDEBUG:-}
if [ "${ENABLE_XDEBUG}" = true ]; then
    echo "Enabling XDebug.."
	cp /config/xdebug-on.ini /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
	echo "XDebug has been enabled"
else
    echo "Disabling XDebug.."
	cp /config/xdebug-off.ini /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
    echo "XDebug has been disabled"
fi

# Apply settings files:

if [ -f /settings/000-default.conf ]; then
    cp /settings/000-default.conf /etc/apache2/sites-available/000-default.conf
fi
if [ -f /settings/phpunit.xml ]; then
    cp /settings/phpunit.xml /var/www/html/core/phpunit.xml
fi
if [ -f /settings/apache2.conf ]; then
    cp /settings/apache2.conf /etc/apache2/apache2.conf
fi
if [ -f /settings/envvars ]; then
    cp /settings/envvars /etc/apache2/envvars
fi
if [ -f /settings/ports.conf ]; then
    cp /settings/ports.conf /etc/apache2/ports.conf
fi
if [ -f /settings/sshd_config ]; then
    cp /settings/sshd_config /etc/ssh/sshd_config
fi
if [ -f /settings/php.ini ]; then
    echo "adding custom php.ini"
    cp /settings/php.ini "$PHP_INI_DIR/php.ini"
fi
if [ -f /settings/20-xdebug.ini ]; then
    cp /settings/20-xdebug.ini /etc/php/apache2/conf.d/20-xdebug.ini
fi
if [ -f /settings/supervisord.conf ]; then
    cp /settings/supervisord.conf /etc/supervisor/supervisord.conf
fi

# configure platform:
source ~/.bashrc

# fix e2e testing issue related to selenium:
# https://github.com/elgalu/docker-selenium/issues/20#issuecomment-133011186
umount /dev/shm
mount -t tmpfs -o rw,nosuid,nodev,noexec,relatime,size=512M tmpfs /dev/shm
# Start supervisord:
echo "Starting supervisord.."
/usr/bin/supervisord