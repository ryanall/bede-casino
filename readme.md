![Bede Casino](http://i.imgur.com/TfWFSAy.png "Bede Casino")

#### Features
1. As an administrator when I am editing the site, I must be able to securely add casinos
name, location and opening times
2. As an administrator I must be able to edit casinos details
3. As an administrator I can delete a casino
4. As a user I should be able to search for the nearest casino to my current location
5. As a user I should be able to see casinos on a map

#### Steps to setup:
1. Git clone locally on your developer instance
2. Run `composer install` in root directory of application to install dependencies (composer.lock used to lock dependencies)
3. Create VHOST pointing to public folder of application. If using, homestead would be:
```
serve bede-casino.dev ~/Code/apps/bede-casino.dev/public
```
4. Update host file with new host bede-casino.dev
5. Update .env file with your MySQL details in root
6. Run `php artisan migrate` (_to create database tables_)
7. Run `php artisan db:seed` (_to create test data_)
8. Access application - Note! If you wish to manage casinos, create an account top right.

#### Unit Test(s)
Mockery has been used - three tests added covering `CasinosApiController`.
Run from root of application:
```
phpunit
```