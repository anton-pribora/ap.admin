FROM php:8.1-fpm
RUN apt-get update && apt-get install -y \
		libfreetype6-dev \
		libjpeg62-turbo-dev \
		libpng-dev \
        libicu-dev \
        libtidy-dev \
        libzip-dev \
	&& docker-php-ext-configure gd --with-freetype --with-jpeg \
	&& docker-php-ext-install -j$(nproc) gd exif pdo pdo_mysql intl tidy zip

ARG UID=1000
ARG GID=1000

RUN groupadd -g "${GID}" dockerphp \
  && useradd --create-home --no-log-init -u "${UID}" -g "${GID}" dockerphp

USER dockerphp
