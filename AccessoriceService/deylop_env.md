# INSTALLATION GUIDE FOR BMS PROJECT
##1. Install XAMPP v7.3.4
- [Download](https://www.apachefriends.org/index.html)
- Environment :
    * Apache version 2.4.39   
    >`httpd -v`
    * PHP version 7.3.4  
    >`php -v`
    * MySQL version  10.1.38  
    >`mysql.exe -v` or `mysql.exe -V`

- Config environment path in Window  
	`C:\xampp\php`


##2. Install Composer v1.8.5 
- [Download](https://getcomposer.org/download/)
- Check version:     
    >`composer -V`
	
- Update package througth composer:
    >`composer update`
##3. Install Laravel  v5.8
- [Document](https://laravel.com/docs/5.8)

- Commmand line :  
	>`composer global require laravel/installer`

- Create new project by command line (skip this step if not needed):  
    >`composer create-project --prefer-dist laravel/laravel {Project}`

- Config vhost in:     `C:\xampp\apache\conf\extra\httpd-vhosts.conf`
    ~~~~
    <VirtualHost *:80>
          ServerName laravel.example.com
          DocumentRoot C:/xampp/htdocs/{Projet}/public
    
          <Directory C:/xampp/htdocs/{Projet}>
                 AllowOverride All
          </Directory>
    </VirtualHost>
    ~~~~
- Config host file in C:\Windows\System32\Drivers\etc\hosts (add new line) :  
    >`127.0.0.1       {host_name}.com.vn`

- Add new or update .env file
    * default config file :
        ~~~~
        APP_NAME=BMS
        APP_ENV=local
        APP_KEY=base64:X0hUJq8uxmfiu26veT+A+7vAUoOWwdBOiYCAegqs9UM=
        APP_DEBUG=true
        APP_URL=http://localhost
        
        LOG_CHANNEL=stack
        
        DB_CONNECTION=mysql
        DB_HOST=127.0.0.1
        DB_PORT=3306
        DB_DATABASE=
        DB_USERNAME=
        DB_PASSWORD=
        
        BROADCAST_DRIVER=log
        CACHE_DRIVER=file
        QUEUE_CONNECTION=sync
        SESSION_DRIVER=file
        SESSION_LIFETIME=120
        
        REDIS_HOST=127.0.0.1
        REDIS_PASSWORD=null
        REDIS_PORT=6379
        
        MAIL_DRIVER=smtp
        MAIL_HOST=smtp.mailtrap.io
        MAIL_PORT=2525
        MAIL_USERNAME=null
        MAIL_PASSWORD=null
        MAIL_ENCRYPTION=null
        
        AWS_ACCESS_KEY_ID=
        AWS_SECRET_ACCESS_KEY=
        AWS_DEFAULT_REGION=us-east-1
        AWS_BUCKET=
        
        PUSHER_APP_ID=
        PUSHER_APP_KEY=
        PUSHER_APP_SECRET=
        PUSHER_APP_CLUSTER=mt1
        
        MIX_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
        MIX_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"
        ~~~~
##4. Admin LTE 3 
- [Document](https://adminlte.io/)

- [Download](https://github.com/ColorlibHQ/AdminLTE/archive/v2.4.3.zip)

- Bootstraps version 4
- <hr>
# PROJECT STRUCTURE

~~~~
|.idea/
|- app/
    |- Console/
    |- Exceptions/
    |- Http/
        |- Controllers/
            |- Auth
        |- Middleware/
    |- Model/
    |- Rules/
    |- ServiceImpl/
    |- Services/
    |- Providers/
|- bootstrap/
|- config/    
|- database/
    |factories/
    |migrations/
    |seeds/
|- public/
    |- css/
    |- js/
    |- plugin/
|- resources/
    |- js/
    |- lang/
        |- en/
        |- jp/
        |- vn/
    |- views/
|- routes/  
|- storage/    
|- test/  
~~~~
# Clear cache
- Reoptimized class loader:  
>php artisan optimize  

- Clear Cache facade value:  
>php artisan cache:clear
- Clear Route cache:
>php artisan route:cache  

 Clear View cache:
>php artisan view:clear

- Clear Config cache:
>php artisan config:cache
Other

Expired reset tokens clear
>php artisan auth:clear-resets

Migration created successfully
>php artisan session:table

Telescope entires cleared
>php artisan telescope:clear

Cache event cleared
>php artisan event:clear















