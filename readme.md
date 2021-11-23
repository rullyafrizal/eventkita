## Tech Stack
- Laravel 8.*
- PHP 7.4
- MySQL 8.0
- NodeJS 14.*

## Installation

1. Clone the repository
    ```bash
    git clone git@github.com:rullyafrizal/eventkita.git
    ```

2. Configure .env files, => copy .env.example and rename it to .env

3. Set up all configuration in .env files

4. Use the package manager [composer](https://getcomposer.org/download/) to install vendor.

    ```bash
    composer install
    ```

5. Generate APP_KEY

    ```bash
    php artisan key:generate
    ```

6. Install node_modules

    ```bash
    npm install
    ```

7. Run Migration

    ```bash
    php artisan migrate
    ```

8. Run Seeder

    ```bash
    php artisan db:seed
    ```
9. Run Laravel server

     ```bash
     php artisan serve
     ```

10. Run npm watch

     ```bash
     npm run watch
     ```
   
- Basic Admin Credential

    ```bash
    username: admin@admin.com
    password: Admin123
    ```

## Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.


## License
[MIT](https://choosealicense.com/licenses/mit/)
