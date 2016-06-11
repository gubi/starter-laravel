FROM debian:jessie

MAINTAINER "Ivan Candela" <icandela@zikkio.com>

COPY ./src /www/data/app

VOLUME ["/www/data/app"]
