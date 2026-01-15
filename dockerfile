FROM php:8.2-cli

# Thư mục làm việc
WORKDIR /app

# Copy toàn bộ source
COPY . .

# Cài extension PHP thường dùng
RUN docker-php-ext-install pdo pdo_mysql

# Nếu có composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
 && php composer-setup.php --install-dir=/usr/local/bin --filename=composer \
 && composer install --no-dev || true

# Render bắt buộc port 10000
EXPOSE 10000

# Chạy PHP built-in server, trỏ root
CMD ["php", "-S", "0.0.0.0:10000", "-t", "."]
