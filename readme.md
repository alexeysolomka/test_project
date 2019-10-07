**Install PostgreSql**
#
In postgresql console run:
- psql -d yourdatabase -c "CREATE EXTENSION postgis;"
**Run composer update**
#
**Run php artisan migrate:fresh**
#
**Run php artisan db:seed --class=RolesTableSeeder**
#
In user seeder change phone number to your phone number after run 
**php artisan db:seed --class=UserSeeder**
#
**Run php artisan db:seed --class=FakeUsers**
#
**Run php artisan db:seed --class=PermissionTableSeeder**
#
**Run php artisan db:seed --class=StationSeeder**
#
**php artisan passport:install**
