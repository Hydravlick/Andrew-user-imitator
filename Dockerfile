FROM php:8-fpm

WORKDIR /app

RUN apt-get update
RUN apt-get install -y git zip unzip