FROM php:7.1-fpm

# APT-GET installs
RUN apt-get update \
&& export DEBIAN_FRONTEND=noninteractive \
&& apt-get install -y --no-install-recommends apt-utils \
&& apt-get install -y curl \
&& apt-get install -y libcurl4-gnutls-dev \
&& apt-get install -y libicu-dev \
&& apt-get install -y libmcrypt-dev \
&& apt-get install -y libpng-dev \
&& apt-get install -y libssl-dev \
&& apt-get install -y libxml2-dev \
&& apt-get install -y -q git \
&& apt-get install -y -q rake \
&& apt-get install -y -q ruby-ronn zlib1g-dev && apt-get clean \
&& rm -rf /var/lib/apt/lists/*

# PHP Extensions
RUN docker-php-ext-install bcmath curl gd json mbstring mcrypt opcache pcntl pdo_mysql soap

# install composer
RUN cd /usr/local/bin && curl -sS https://getcomposer.org/installer | php
RUN cd /usr/local/bin && mv composer.phar composer

# Extensions by PECL
# install grpc
RUN pecl install grpc \
&& docker-php-ext-enable grpc \
&& echo "extension=grpc.so" >> /usr/local/etc/php/conf.d/grpc.ini

#install protoc
#RUN mkdir -p /tmp/protoc
#RUN curl -L https://github.com/google/protobuf/releases/download/v3.11.2/protoc-3.11.2-linux-x86_64.zip > /tmp/protoc/protoc.zip
#RUN cd /tmp/protoc && unzip protoc.zip && cp /tmp/protoc/bin/protoc /usr/local/bin
#RUN cd /tmp && rm -r /tmp/protoc
#RUN docker-php-ext-enable grpc
#RUN echo "extension=grpc.so" >> /usr/local/etc/php/conf.d/grpc.ini

RUN pecl install protobuf
RUN docker-php-ext-enable protobuf
RUN echo "extension=protobuf.so" >> /usr/local/etc/php/conf.d/protobuf.ini

RUN pecl install xdebug-2.7.2 \
&& docker-php-ext-enable xdebug \
&& echo "xdebug.remote_enable=1" >> /usr/local/etc/php/conf.d/xdebug.ini \
&& echo "xdebug.remote_handler=dbgp" >> /usr/local/etc/php/conf.d/xdebug.ini \
&& echo "xdebug.remote_autostart=1" >> /usr/local/etc/php/conf.d/xdebug.ini \
&& echo "xdebug.remote_connect_back=0" >> /usr/local/etc/php/conf.d/xdebug.ini \
&& echo "xdebug.remote_host=172.17.0.1" >> /usr/local/etc/php/conf.d/xdebug.ini \
&& echo "xdebug.remote_port=9126" >> /usr/local/etc/php/conf.d/xdebug.ini \
&& echo "xdebug.idekey=sonic" >> /usr/local/etc/php/conf.d/xdebug.ini \
&& echo "xdebug.profiler_enable_trigger=1" >> /usr/local/etc/php/conf.d/xdebug.ini \
&& echo "xdebug.profiler_output_dir=/tmp/profiler" >> /usr/local/etc/php/conf.d/xdebug.ini \
&& echo "xdebug.profiler_output_name=cachegrind.out.%t-%s" >> /usr/local/etc/php/conf.d/xdebug.ini

# PHP Configuration
RUN echo "date.timezone=UTC" > /usr/local/etc/php/conf.d/timezone_sao_paulo.ini
RUN echo "upload_max_filesize=50M" >> /usr/local/etc/php/conf.d/max_size.ini

EXPOSE 9000

WORKDIR /app
CMD ["php-fpm"]
