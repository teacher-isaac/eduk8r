FROM php:fpm-alpine3.18
COPY nginx.conf /etc/nginx/http.d/default.conf
WORKDIR /var/www/eduk8r
COPY www/ www/
RUN apk --no-cache add nginx
CMD nginx -g "daemon off;"
EXPOSE 8080
