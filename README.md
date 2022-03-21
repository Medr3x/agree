# Agree

# Requiremientos del Servidor

    - Laravel 8 & MySQL
    - PHP >= 7.4

# Instalación

    git clone https://github.com/Medr3x/agree.git agree
    composer install
    cp example.env .env
    php artisan key:generate

# Editar .env
    *Crear BD*
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=db_name
    DB_USERNAME=db_username
    DB_PASSWORD=db_password
     
# Luego ejecutar

    php artisan migrate:fresh --seed
    php artisan passport:install
    php artisan l5-swagger:generate

 
