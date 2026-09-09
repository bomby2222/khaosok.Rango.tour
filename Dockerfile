FROM richarvey/nginx-php-fpm:3.1.6

# คัดลอกโค้ดทั้งหมดเข้า Container
COPY . /var/www/html

# ตั้งค่า Nginx และ PHP สำหรับ Laravel
ENV SKIP_COMPOSER 0
ENV WEBROOT /var/www/html/public
ENV PHP_ERRORS_STDERR 1
ENV RUN_SCRIPTS 1
ENV REAL_IP_HEADER 1

# ตั้งค่า Permission ให้ Laravel Storage เขียนไฟล์ได้
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache