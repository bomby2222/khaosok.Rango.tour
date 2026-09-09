FROM richarvey/nginx-php-fpm:3.1.6

# คัดลอกไฟล์โปรเจกต์ทั้งหมดเข้า Container
COPY . /var/www/html

WORKDIR /var/www/html

# ติดตั้งแพ็กเกจโดยใส่ --no-scripts เพื่อไม่ให้ artisan ทำงานก่อนมีไฟล์ Config/Database
RUN composer install --no-dev --prefer-dist --optimize-autoloader --no-interaction --no-scripts

# ตั้งค่า Nginx & PHP
ENV WEBROOT /var/www/html/public
ENV PHP_ERRORS_STDERR 1
ENV RUN_SCRIPTS 1
ENV REAL_IP_HEADER 1

# กำหนดสิทธิ์ให้โฟลเดอร์ Cache และ Storage
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache