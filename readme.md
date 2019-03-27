## Description
This is a small module allow update profile (`address`) for user. I use JwtAuth to check to authentication

## Installation
> cd project_path  
composer install && npm install  
cp .env.example .env  
vi .env  
// update file .env  
DB_DATABASE=  
DB_USERNAME=  
DB_PASSWORD=  

## Run project
> php artisan db:seed   
php artisan migrate  
php artisan serve  

## Update profile for user
First, we need to get JWTtoken via `php artisan generate_jwt_token`  
This command will get random a user & return a string jwttoken of that user. You have to use this token to update profile for that user
> You can Specified a user via `php artisan generate_jwt_token {userId}`

Run this command below. Remember to replace {Token} with your token above
> curl --request PUT \
    --url http://localhost:8000/api/me \
    --header 'authorization: Bearer {Token}' \
    --header 'cache-control: no-cache' \
    --header 'content-type: application/json' \
    --data '{\n	"address": "This is a new address"\n}'

## Run Unit-test
> ./vendor/bin/phpunit tests
