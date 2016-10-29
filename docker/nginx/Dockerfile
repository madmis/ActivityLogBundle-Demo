FROM nginx:1.11

#+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
RUN echo 'PS1="\[\033[36m\]\u\[\033[m\]@\[\033[95;1m\]docker-nginx:\[\033[34m\]\w\[\033[m\]\$ "' >> ~/.bashrc
#+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

#+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
RUN apt-get update && apt-get install -y \
    vim \
    wget \
    apt-utils
#+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

ADD app.conf /etc/nginx/conf.d/
RUN rm /etc/nginx/conf.d/default.conf
RUN rm /etc/nginx/nginx.conf
COPY nginx.conf /etc/nginx/

RUN mkdir -p /var/www/web

WORKDIR /var/www/

COPY ./docker-entrypoint.sh /
RUN chmod +x /docker-entrypoint.sh

ENTRYPOINT ["/bin/bash", "/docker-entrypoint.sh"]

