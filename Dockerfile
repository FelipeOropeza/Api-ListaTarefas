# Use uma imagem oficial do PHP com Apache
FROM php:8.1-apache

# Instala as dependências necessárias para o PHP e o Composer
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    && docker-php-ext-install pdo_mysql

# Instala o Composer globalmente
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Define o diretório de trabalho
WORKDIR /var/www/html/public

# Copia os arquivos do projeto para o diretório raiz do servidor
COPY . /var/www/html

# Instala as dependências do Composer
RUN composer install

RUN echo "DirectoryIndex index.php index.html" >> /etc/apache2/apache2.conf

# Configura a porta e o comando para iniciar o servidor
EXPOSE 80
CMD ["apache2-foreground"]
