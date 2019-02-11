rm -rf /app/var/cache/* /app/var/logs/* /app/var/sessions/*
chown -R www-data:www-data /app/var/cache /app/var/logs /app/var/sessions
chmod -R 777 /app/var/cache /app/var/logs /app/var/sessions
