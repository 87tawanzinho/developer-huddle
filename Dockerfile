
# Use uma imagem oficial do PHP com Nginx
FROM php:8.2-fpm

# Instalar dependências necessárias
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    git \
    nginx \
    curl \
    nodejs \
    npm \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql

# Instalar Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

RUN rm -rf /etc/nginx/sites-enabled/* /etc/nginx/sites-available/*

# Configuração do Nginx
COPY nginx/default.conf /etc/nginx/sites-enabled/default.conf

# Copiar o código da aplicação
WORKDIR /var/www
COPY . .

# Definir permissões corretas para diretórios
RUN chown -R www-data:www-data /var/www

# Instalar dependências do Laravel
RUN composer install --no-dev --optimize-autoloader

# Instalar dependências do Node.js e executar build
RUN npm install && npm run build

# Expor portas necessárias
EXPOSE 8080 8443

# Comando para iniciar o PHP-FPM e o Nginx
CMD ["sh", "-c", "php-fpm -D && nginx -c /etc/nginx/nginx.conf  -g 'daemon off;'" ]
