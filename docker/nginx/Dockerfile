# docker/nginx/Dockerfile
FROM nginx:1.25.0-alpine-slim
ADD myradar.nginx.conf /etc/nginx/conf.d/default.conf

WORKDIR /var/www/html/myradar


# RUN pwd
# RUN chown -R root:www-data storage
# RUN chown -R root:www-data bootstrap/cache
# RUN chmod -R 775 storage
# RUN chmod -R 775 bootstrap/cache