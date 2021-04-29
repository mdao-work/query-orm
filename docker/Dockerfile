FROM registry.cn-hangzhou.aliyuncs.com/mdao/docker_php73:latest

WORKDIR /www
COPY . /www
COPY ./.env.development /www/.env

COPY docker/crontab/root /etc/crontabs/root
COPY docker/nginx/conf.d/default.conf /etc/nginx/conf.d/default.conf
COPY docker/phpconf/php.ini /usr/local/etc/php/php.ini
COPY docker/pm2/apps.json /etc/pm2/apps.json

RUN composer install --no-dev  > /dev/null 2>&1 && composer clearcache && chmod -R 777 runtime
WORKDIR /www/public/uploads
RUN chmod -R 777 app_logo &&  chmod -R 777 xlsx
WORKDIR /www
#RUN mkdir -p /data/www \
#&& tar -zcvf /data/www/www.tar.gz --exclude=.git /www  > /dev/null 2>&1 \
#&& rm -rf /www/* && ls -l /www

