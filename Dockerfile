FROM php:fpm-alpine3.18
COPY nginx.conf /etc/nginx/http.d/default.conf
WORKDIR /var/www/eduk8r
COPY www/ www/
RUN apk --no-cache add nginx php-fpm
COPY php-fpm-overrides.conf /usr/local/etc/php-fpm.d/~overrides.conf
CMD php-fpm -D; nginx -g "daemon off;"
EXPOSE 8080
