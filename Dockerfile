FROM dunglas/frankenphp AS base

RUN install-php-extensions \
    bcmath \
    curl \
    intl \
    mbstring \
    opcache \
    pcntl \
    pdo_pgsql \
    redis \
    zip \
    @composer \
    ;

RUN apt-get update && apt-get install -y \
    postgresql-client \
    && rm -rf /var/lib/apt/lists/*

ENTRYPOINT ["php", "artisan", "octane:frankenphp"]


FROM base AS prod

COPY . /app


FROM base AS dev

RUN install-php-extensions \
    xdebug \
    ;
