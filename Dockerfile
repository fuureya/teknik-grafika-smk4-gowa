FROM nginx:alpine

# enable edge/testing repo for latest nodejs-lts (v20+)
RUN echo "https://dl-cdn.alpinelinux.org/alpine/edge/main" >> /etc/apk/repositories && \
    echo "https://dl-cdn.alpinelinux.org/alpine/edge/community" >> /etc/apk/repositories && \
    echo "https://dl-cdn.alpinelinux.org/alpine/edge/testing" >> /etc/apk/repositories

# install packages
RUN apk add --no-cache \
    bash \
    git \
    curl \
    unzip \
    zip \
    nodejs-current \
    npm \
    supervisor \
    libzip-dev \
    oniguruma-dev \
    autoconf \
    gcc \
    g++ \
    make \
    openssl \
    php84 \
    php84-fpm \
    php84-pdo \
    php84-pdo_mysql \
    php84-mysqli \
    php84-opcache \
    php84-session \
    php84-ctype \
    php84-curl \
    php84-phar \
    php84-iconv \
    php84-mbstring \
    php84-tokenizer \
    php84-xml \
    php84-simplexml \
    php84-gd \
    php84-xmlwriter \
    php84-xmlreader \
    php84-fileinfo \
    php84-zip \
    php84-dom \
    && ln -s /usr/bin/php84 /usr/bin/php

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
COPY ./nginx/default.conf /etc/nginx/conf.d/default.conf

# CMD with background composer dev and foreground nginx
CMD ["/bin/sh", "-c", "php-fpm84 -D && composer run dev & nginx -g 'daemon off;'"]

# php-fpm user to nginx
RUN sed -i 's/^user = .*/user = nginx/' /etc/php84/php-fpm.d/www.conf && \
    sed -i 's/^group = .*/group = nginx/' /etc/php84/php-fpm.d/www.conf

# FIXED: Increase upload limits and timeouts for PDF with signatures
RUN printf "upload_max_filesize = 100M\npost_max_size = 100M\nmemory_limit = 512M\nmax_execution_time = 300\nmax_input_time = 300" > /etc/php84/php.ini    

EXPOSE 80
FROM nginx:alpine

# enable edge/testing repo for latest nodejs-lts (v20+)
RUN echo "https://dl-cdn.alpinelinux.org/alpine/edge/main" >> /etc/apk/repositories && \
    echo "https://dl-cdn.alpinelinux.org/alpine/edge/community" >> /etc/apk/repositories && \
    echo "https://dl-cdn.alpinelinux.org/alpine/edge/testing" >> /etc/apk/repositories

# install packages
RUN apk add --no-cache \
    nano \
    bash \
    git \
    curl \
    unzip \
    zip \
    nodejs-current \
    npm \
    supervisor \
    libzip-dev \
    oniguruma-dev \
    autoconf \
    gcc \
    g++ \
    make \
    openssl \
    php84 \
    php84-fpm \
    php84-pdo \
    php84-pdo_mysql \
    php84-mysqli \
    php84-opcache \
    php84-session \
    php84-ctype \
    php84-curl \
    php84-phar \
    php84-iconv \
    php84-mbstring \
    php84-tokenizer \
    php84-xml \
    php84-simplexml \
    php84-gd \
    php84-xmlwriter \
    php84-xmlreader \
    php84-fileinfo \
    php84-zip \
    php84-dom \
    && ln -s /usr/bin/php84 /usr/bin/php

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# php-fpm user to nginx
RUN sed -i 's/^user = .*/user = nginx/' /etc/php84/php-fpm.d/www.conf && \
    sed -i 's/^group = .*/group = nginx/' /etc/php84/php-fpm.d/www.conf

# FIXED: Increase upload limits and timeouts for PDF with signatures
RUN printf "upload_max_filesize = 2M\npost_max_size = 100M\nmemory_limit = 512M\nmax_execution_time = 300\nmax_input_time = 300" > /etc/php84/php.ini

WORKDIR /var/www/html
COPY ./nginx/default.conf /etc/nginx/conf.d/default.conf
COPY ./entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

CMD ["/entrypoint.sh"]

EXPOSE 80