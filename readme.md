# Home Work

Server get currencies from markets via api and send it to client via
websockets. For websockets on this projects read  <a href="https://docs.beyondco.de/laravel-websockets/">WebSocket</a>

### Hosting

To do


### Deployment
Project should be deploy manually via git clone. <br>

### Installation:
Copy .env.example -> .env<br>
Open .env file and put your database settings and app URL<br> 

````
APP_URL=http://your_app_url

DB_DATABASE=your_db_name
DB_USERNAME=your_db_user
DB_PASSWORD=your_db_password
````
  
Install laravel, generate application key:
````
    php composer.phar install
    php artisan key:generate
````

Run migration and seeds:
````
 php artisan migrate
 php artisan db:seed
````

Run websocket server:
````
php artisan websocket:serve
````


### Versions

* <a href="https://laravel.com/">Laravel</a>: 5.8
* <a href="http://www.php.net/">PHP<a>: 7.1.19
* <a href="https://vuejs.org/">VueJS</a>: 2.5.17
* <a href="https://getbootstrap.com/">Bootstrap</a>: 4.0


    

