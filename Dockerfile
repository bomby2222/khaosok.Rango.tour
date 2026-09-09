FROM richarvey/nginx-php-fpm:3.1.6

# คัดลอกไฟล์ทั้งหมดเข้า Container
COPY . /var/www/html

WORKDIR /var/www/html

# ติดตั้ง Composer Dependencies สำหรับ Production
RUN composer install --no-dev --prefer-dist --optimize-autoloader --no-interaction

# ตั้งค่า Nginx & PHP
ENV WEBROOT /var/www/html/public
ENV PHP_ERRORS_STDERR 1
ENV RUN_SCRIPTS 1
ENV REAL_IP_HEADER 1

# ให้สิทธิ์เขียนไฟล์แก่ Storage และ Cache
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache