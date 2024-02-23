FROM php:8.3.2-fpm

ARG USER_ID
ARG GROUP_ID

RUN if [ -z "$USER_ID" ]; then RED='\033[0;31m';GREEN='\033[0;32m';echo "${RED}Build images with USER_ID arg: ${GREEN}docker-compose build --build-arg USER_ID=$(id -u)";exit 1;fi;
RUN if [ -z "$GROUP_ID" ]; then RED='\033[0;31m';GREEN='\033[0;32m';echo "${RED}Build images with GROUP_ID arg: ${GREEN}docker-compose build --build-arg GROUP_ID=$(id -g)";exit 1;fi;
RUN getent group $GROUP_ID || addgroup  --gid $GROUP_ID user
RUN adduser --disabled-password --gecos '' --uid $USER_ID --gid $GROUP_ID user

RUN apt-get update && \
    apt-get upgrade -y

RUN apt-get install -y --no-install-recommends git zip unzip

# install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer --2

USER user
