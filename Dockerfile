FROM php:fpm-alpine3.18
RUN apk --no-cache add nginx php-fpm
COPY docker/nginx.conf /etc/nginx/http.d/default.conf
COPY docker/php-fpm-overrides.conf /usr/local/etc/php-fpm.d/~overrides.conf
WORKDIR /var/www/eduk8r
COPY www/ www/
CMD php-fpm -D; nginx -g "daemon off;"
EXPOSE 8080