Client Site
===============

Version v1.0
- initial project

### Requirements
----------------
- Minimal Web server kamu suppport PHP 5.4.0.
- Database sqlite dan PDO SQLite extension haurs di aktifkan,

### Instalation
---------------
Ketikan perintah berikut di dalam directory htdocs / webroot kamu
```
git clone [url-git] client-side
cd client-side
composer global require "fxp/composer-asset-plugin:^1.2.0"
composer install -vvv
php yii migrate
```
Ubah pengaturan akses url api dan token `client-side\config\params.php`:
```
http://localhost/server-side/api/public_html/v1/
```

Sekarang kamu sudah bisa mengakses aplikasi menggunakan url :
```
http://localhost/client-side/public_html
```

### Menu yang tersedia
- Repository & history repository : SCRUD (Search, Create, Read, Update, Delete, Sorting) tanpa REST
- Third party services menggunakan S3 Amazon Servies
- Akses login, signup, ubah akun dan password, hapus user menggunakan REST dari source [`https://github.com/m-alfan/test-serverside.git`](https://github.com/m-alfan/test-serverside.git)

### Config Database
-------------------
Default database yang di gunakan aplikasi adalah sqlite, jika kamu ingin mengubahnya, silakan ganti akses db di file `client-side\config\db.php`
```
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=client-side',
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8',
];
```
lakukan migrasi data ke database baru
```
php yii migrate
```

### Demo
- [REST API](http://api.muhamadalfan.com/v1)
- [Client](http://client.muhamadalfan.com)