Cara mengaktifkan sistemnya:
1. Download file
2. Unzip kedalam folder tertentu (contoh: /var/www/html)
3. masuk kedalam folder apps ini.
4. kemudian ketikkan: cp .env.example .env
5. ketikkan composer install
6. ketikkan php artisan migrate
7. ketikkan php artisan db:seed

untuk test, menggunakan postman
api ada di /api/users
method: POST menggunakan form body untuk name, email, password (dihash) 
method: GET mendapatkan list dari users (saya tambahan sortDesc: true/false untuk sorting asc/desc)

terima kasih.
