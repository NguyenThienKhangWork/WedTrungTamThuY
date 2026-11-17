# ==========================================================
# PawNest & CozyPaws - Dockerfile (PHP 8.2 + Apache)
# ==========================================================

FROM php:8.2-apache

# Cài đặt extension PDO MySQL cần thiết cho dự án
RUN docker-php-ext-install pdo pdo_mysql

# Bật Apache mod_rewrite
RUN a2enmod rewrite

# Cấu hình thư mục làm việc
WORKDIR /var/www/html

# Sao chép mã nguồn vào container
COPY . /var/www/html/

# Phân quyền thư mục
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Expose port 80
EXPOSE 80

CMD ["apache2-foreground"]
