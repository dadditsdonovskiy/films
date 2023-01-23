
## GBKSOFT base laravel

### First Start (Introduction) : 

#### 1) Copy environment variables and fill them :
  ```shell script
cp .env.example .env
```

#### 2) Run docker all containers :
  ```shell script
 docker-compose up --build -d
 ```

#### 3) Install packages :
  ```shell script
docker-compose exec -u "www-data" web-php composer install
  ``` 
#### 4) Run migration :
  ```shell script
docker-compose exec -u "www-data" web-php php artisan migrate

  ``` 
#### 5) Create the encryption keys needed to generate secure access tokens

  ```shell script 
 docker-compose exec -u "www-data" web-php php artisan key:generate
  ``` 
#### 6) Install npm packages and run dev script:
```shell script
docker-compose exec -u "www-data" web-php npm i
docker-compose exec -u "www-data" web-php npm run dev
``` 
### Run tests : 

```shell script
docker-compose exec -u "www-data" web-php php artisan test
docker-compose exec -u "www-data" web-php ./vendor/bin/dep tests
```

### Debug dashboard  - Telescope  {MAIN_DOMAIN}/telescope

#### Install
 ```shell script
 docker-compose exec -u "www-data" web-php php artisan telescope:install
 ```
#### Enable  - set .env  TELESCOPE_ENABLED=true , if use not local env you must add
 email user in App\Providers\TelescopeServiceProvider->gate()
 ```php
         Gate::define('viewTelescope', function ($user) {
             return in_array($user->email, [
                 'admin@nosend.net'
             ]);
         });
 ```       

### Laravel CLI :

| Command | Description |
| --- | --- |
| create:user | Create user  |
| optimize | Cache the framework bootstrap files |
| auth:clear-resets | Flush expired password reset tokens |
| config:cache | Create a cache file for faster configuration loading |
| config:clear | Remove the configuration cache file |
| view:cache | Compile all of the application's Blade templates|
| view:clear | Clear all compiled view files|

Full list command:
```shell script
docker-compose exec -u "www-data" web-php php artisan list
```

Project setup via .env
-------------------

### How to add configuration to .env file:
* Make .env file (or other file with .env suffix - like .dev.env)
* Move base set of options from .env.example to file you made (!!IMPORTANT variables present in .env.example are required and must be in .env file or have to be removed from *.php environment configuration )
* To create new configuration option use template in placeholder's name - {{SOME_KEY}}, will be replaced with value from .env file
* !!!IMPORTANT Do not use quotes in .env file
```
    SOME_KEY=<some value>
```
##### Most common .env variables
```
    MAIN_DOMAIN= application domain
    REST_DOMAIN= API domain
    BACKEND_DOMAIN= admin domain
    DEPLOY_DOMAIN= domain to deploy remotely 
    DEPLOY_USER= deploy user when deploy remotely
    DEPLOY_PORT=deploy port when deploy remotely
    DEPLOY_KEY_PATH= deploy key when deploy remotely
    DEPLOY_PATH= deploy path when deploy remotely
    DB_USERNAME= db username
    DB_PASSWORD= db password
    DB_NAME= db name
    DB_HOST= db host
    DB_PORT= db post
    DB_ROOT_PASSWORD= db password when need more permissions (default root username  is root)
    DB_TEST_HOST= test env host
    DB_TEST_NAME= test env name
    DB_TEST_PORT= test env port

```


### How this works?:
 Script reads configuration from chosen .env file
 On finding {{SOME_KEY}}, replacing this placeholder with value
 
