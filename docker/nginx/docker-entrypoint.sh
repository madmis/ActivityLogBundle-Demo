#!/usr/bin/env bash

set -e

sed -i "s#{{NGINX_HOST}}#${NGINX_HOST}#g" /etc/nginx/conf.d/app.conf

sleep 5 && nginx -g 'daemon off;'