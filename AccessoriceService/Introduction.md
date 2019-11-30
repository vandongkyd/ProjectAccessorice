## Create table
php artisan make:migration create_%name%_table

## Rolling Back
php artisan migrate:rollback

## Reset
php artisan migrate:reset

## Refresh
php artisan migrate:refresh
php artisan migrate:refresh --seed

## Drop All Tables & Migrate
php artisan migrate:fresh
php artisan migrate:fresh --seed

## Run Once File
php artisan migrate --path=database/migrations/users

## Create Model
php artisan make:model %Name%

## Create Controller
php artisan make:controller %Name%Controller

## Create Controller and Model
php artisan make:controller %Name%Controller --resource --model=%Name%

## Clear cache
php artisan config:clear
php artisan view:clear
php artisan route:cache
php artisan cache:clear
php artisan optimize
## update key generate
php artisan key:generate

## import data in DB test
php artisan data-test