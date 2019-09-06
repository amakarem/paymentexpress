Requirements
------------
These services are required for normal operation:
* [php](https://secure.php.net/downloads.php) 7.2.2+
* [Composer](https://getcomposer.org/download/)
* npm
* OpenSSL PHP Extension
* PDO PHP Extension
* Mbstring PHP Extension
* Tokenizer PHP Extension
* XML PHP Extension
* Ctype PHP Extension
* JSON PHP Extension
* BCMath PHP Extension
* a webserver
* [mysql](https://www.mysql.com/downloads/) 5.6 or compatible DBMS

Installation
------------
1. Make sure the required services are up and running;
2. Clone this repository and checkout needed branch;
3. Create a dedicated clean MySQL (or compatible) database;
4. Run `cp .env.example .env` to create .env file; 
5. Update .env file with DB information and APP_URL and API information;
6. Install required dependencies: `composer install`;
7. Install npm required dependencies `npm install`;
8. Update database: `php artisan migrate`;
9. Activate Admin Panel `php artisan db:seed --class=VoyagerDatabaseSeeder `;
10. Check if everything's up by visiting your page in the web browser, and you are done!


Admin Panel Access
------------
* To create a new admin user you can pass the --create flag, like so: `php artisan voyager:admin your@email.com --create` And you will be prompted for the users name and password.; 