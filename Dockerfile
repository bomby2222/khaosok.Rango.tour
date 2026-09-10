FROM richarvey/nginx-php-fpm:3.1.6

COPY . /var/www/html

WORKDIR /var/www/html

# คัดลอกคอนฟิก Nginx สำหรับ Laravel
COPY nginx-site.conf /etc/nginx/sites-available/default.conf

# ติดตั้ง Composer Dependencies
RUN composer install --no-dev --prefer-dist --optimize-autoloader --no-interaction --no-scripts

# 🔗 1. สร้าง Symbolic Link ให้ระบบดึงรูปจาก storage ออกมาแสดงผลหน้าเว็บ
RUN php artisan storage:link

# ⚙️ 2. ปรับลิมิตขนาดไฟล์อัปโหลดของ PHP เป็น 64MB (ป้องกัน Error 413 / อัปโหลดรูปใหญ่ไม่ผ่าน)
RUN echo "upload_max_filesize = 64M" > /usr/local/etc/php/conf.d/uploads.ini && \
    echo "post_max_size = 64M" >> /usr/local/etc/php/conf.d/uploads.ini && \
    echo "memory_limit = 256M" >> /usr/local/etc/php/conf.d/uploads.ini

# ตั้งค่า Nginx & PHP
ENV WEBROOT /var/www/html/public
ENV PHP_ERRORS_STDERR 1
ENV RUN_SCRIPTS 1
ENV REAL_IP_HEADER 1

# ให้สิทธิ์โฟลเดอร์ storage และ cache ให้เว็บเซิร์ฟเวอร์เขียนไฟล์รูปได้
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache