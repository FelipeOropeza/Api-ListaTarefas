# Use uma imagem oficial do PHP com Composer
FROM php:8.1-apache

# Instala dependências necessárias para o PHP e Composer
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    && docker-php-ext-install pdo_mysql

# Copie os arquivos da aplicação para o diretório raiz do servidor
COPY . /var/www/html

# Instala as dependências do Composer
WORKDIR /var/www/html
RUN php composer.phar install

# Configura a porta e o comando para iniciar o servidor
EXPOSE 80
CMD ["apache2-foreground"]
