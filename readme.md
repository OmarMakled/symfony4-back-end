# REST API Symfony4 & Vue.js

![internations](https://user-images.githubusercontent.com/3720473/51105484-c3bcd380-17f1-11e9-90b0-5d898d354d04.gif)


## APIS
| type   | url                         | payload        | description            |
|--------|-----------------------------|----------------|------------------------|
| GET    | /api/users                  |                | get all users          |
| POST   | /api/users                  | {name: string} | add user               |
| DELETE | /api/users/{id}             |                | delete user            |
| GET    | /api/groups                 |                | get all groups         |
| POST   | /api/groups                 | {name: string} | add group              |
| DELETE | /api/groups/{id}            |                | delete group           |
| POST   | /api/users/{id}/groups/{id} |                | attach group to user   |
| DELETE | /api/users/{id}/groups/{id} |                | detach group from user |


## Project setup
```
git clone git@github.com:OmarMakled/symfony4-back-end.git
cd symfony4-back-end
composer install
set .env DATABASE_URL=
php bin/console doctrine:database:create --no-interaction
php bin/console doctrine:migrations:migrate
php bin/phpunit
php bin/console server:run
```


## DB

![screen shot 2019-01-14 at 11 52 51 am](https://user-images.githubusercontent.com/3720473/51105884-ee5b5c00-17f2-11e9-87a9-25bec51fdee0.png)

## See Also

[VueJS](https://github.com/OmarMakled/symfony4-front-end)

