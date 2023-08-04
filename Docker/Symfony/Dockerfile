FROM php:8.1

ARG UID=1000
ARG GID=1000

RUN apt-get -y update \
  && apt-get install -y libicu-dev libpq-dev\
  && docker-php-ext-configure intl \
  && docker-php-ext-install intl \
  && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
  && docker-php-ext-install pdo pdo_pgsql pgsql

RUN curl -1sLf 'https://dl.cloudsmith.io/public/symfony/stable/setup.deb.sh' | bash

RUN curl -sS https://getcomposer.org/installer -o composer-setup.php \
    && php composer-setup.php --install-dir=/usr/local/bin --filename=composer

RUN apt-get install -y symfony-cli \
    && symfony server:ca:install

RUN apt-get install -y zip unzip

RUN groupadd -g "${GID}" symfonyuser \
    && useradd --create-home --no-log-init -u "${UID}" -g "${GID}" symfonyuser

EXPOSE 8000

USER symfonyuser

WORKDIR /home/symfonyuser/app

ENTRYPOINT ["symfony"]
CMD ["server:start"]