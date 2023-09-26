### RFID PRESENT
Sistem informasi absensi menggunakan RFID Code

#### Installation
```bash
git clone git@github.com:ForYouTeam/rfid-present.git
cd rfid-present
composer install
```

Create .env file from .env.example

#### Running artisan
```bash
php artisan key:generate && php artisan migrate:fresh --seed
```