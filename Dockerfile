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
WORKDIR /var/www/html

# Copia os arquivos do projeto para o diretório raiz do servidor
COPY . /var/www/html

# Instala as dependências do Composer
RUN composer install

# Configuração de permissões e acesso ao diretório public
RUN echo "DirectoryIndex public/index.php" >> /etc/apache2/apache2.conf
RUN echo "<Directory /var/www/html/public>\n\
    AllowOverride All\n\
    Require all granted\n\
</Directory>" >> /etc/apache2/apache2.conf

# Define as permissões para o Apache
RUN chown -R www-data:www-data /var/www/html
RUN chmod -R 755 /var/www/html

# Expõe a porta 80 e inicia o Apache
EXPOSE 80
CMD ["apache2-foreground"]
