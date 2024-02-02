FROM nginx:1.21

RUN apt-get update && apt-get install -y curl wget iputils-ping

COPY ./conf.d/default.conf /etc/nginx/conf.d/default.conf
