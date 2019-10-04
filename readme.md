**Install PostgreSql**
#
In postgresql console run:
- psql -d yourdatabase -c "CREATE EXTENSION postgis;"
- psql -d yourdatabase -c "CREATE EXTENSION postgis_topology;"
- -- if you built with sfcgal support --
- psql -d yourdatabase -c "CREATE EXTENSION postgis_sfcgal;"

- -- if you want to install tiger geocoder --
- psql -d yourdatabase -c "CREATE EXTENSION fuzzystrmatch"
- psql -d yourdatabase -c "CREATE EXTENSION postgis_tiger_geocoder;"

- -- if you installed with pcre
- -- you should have address standardizer extension as well
- psql -d yourdatabase -c "CREATE EXTENSION address_standardizer;"
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
