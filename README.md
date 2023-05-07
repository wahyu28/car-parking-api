# Car Parking API using Laravel

## Screenshots

<div>
    <img src="github-contents/1.png" width="20%"></img> 
    <img src="github-contents/2.png" width="20%"></img> 
    <img src="github-contents/3.png" width="20%"></img> 
    <img src="github-contents/4.png" width="20%"></img> 
    <img src="github-contents/5.png" width="20%"></img> 
    <img src="github-contents/6.png" width="20%"></img> 
    <img src="github-contents/7.png" width="20%"></img> 
    <img src="github-contents/8.png" width="20%"></img> 
    <img src="github-contents/9.png" width="20%"></img> 
    <img src="github-contents/10.png" width="20%"></img> 
    <img src="github-contents/11.png" width="20%"></img> 
    <img src="github-contents/12.png" width="20%"></img> 
    <img src="github-contents/13.png" width="20%"></img> 
    <img src="github-contents/14.png" width="20%"></img>
</div>

# Installation & use

```bash
git clone https://github.com/wahyu28/car-parking-api.git
cd car-parking-api/
composer install
cp .env.example .env
# Now, configure your file .env with your DATABASE
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=

php artisan migrate:refresh --seed
php artisan key:generate
php artisan serve
```
