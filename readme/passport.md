<p align="center"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg"></p>


# Laravel Passport

This project comprises of the helpers, components, functionalities that is being used for laravel application.

> **Laravel Version:** >= Laravel v8.75

> **PHP Version:** >= PHP v7.3


# Configure Laravel Passport

 1.  Install laravel passport while assists to manage JWT api authentication. It generates a unique token for every authenticated user, so every request sent to the API to access protected routes will be accompanied by this token.
```
composer require laravel/passport
```
 2. Passport will need to store OAuth2 clients and access tokens in some database tables, so it creates migrations for the tables during installation. Migrate your database to create the tables:
 ```
php artisan migrate
```
 3. To generate secure access tokens for your application, Passport requires some encryption keys and two clients known as Laravel Personal Access Client and Laravel Password Grant Client. To create these keys and encryption clients, run the following command:
 ```
php artisan passport:install
```
 4. The `HasApiTokens` trait will provide you with some helper methods to carry this out. To add it to your `User` model, navigate to `App\Models\User`, add its namespace at the top, and specify for it to be used inside the `User` class:
```
<?php
namespace  App\Models;
use  Laravel\Passport\HasApiTokens;  //add the namespace
class  User  extends  Authenticatable {
	use  HasApiTokens,  HasFactory,  Notifiable;  //use it here
}
```
 5. Passport comes with some routes used to issue and revoke access tokens. To register these routes, you need to call the `Passport::routes` method inside the boot method in your `AuthServiceProvider`. Navigate to `App\Providers\AuthServiceProvider` and update it. Inside the `$policies` array, comment this line: `'App\Models\Model'  =>  'App\Policies\ModelPolicy'` to make it available for use:

```
<?php
namespace  App\Providers;
use  Laravel\Passport\Passport;  //import Passport here
class  AuthServiceProvider  extends  ServiceProvider {
	 /**
     * The policy mappings for the application.
     *
     * @var array
     */
     
     protected $policies =  [
     'App\Models\Model'  =>  'App\Policies\ModelPolicy',
     ];
     
     * Register any authentication / authorization services.
     *
     * @return void
     */
     public  function  boot() {
	     $this->registerPolicies();
	     Passport::routes();
     }
 }
```

 - Your application needs to use Passport’s `TokenGuard` to authenticate incoming API requests. To set this up, navigate to your `config/auth.php` file, go to your `api` authentication guard, and set the value of the `driver` option to `passport`:
 ```
 'guards'  =>  [
	 'web'  =>  [
		 'driver'  =>  'session',
		 'provider'  =>  'users',
	 ],
	 'api'  =>  [
		 'driver'  =>  'passport',  //update this line
		 'provider'  =>  'users',
	 ],
],
 ```

# Other configuration

 - Create Candidate resource controller and add required conditions.
 - Configure the routes with 3 middle ware.
	 - **Auth:api** - To ensure request is validated with bearer token
	 - **checkhttps** - To ensure request are coming from HTTPS protocol.
	 - **throttle:api** - To throttle the requests that only 60 request should hits the api per minute.
 - For test case, sqlite database is used with **RefreshDatabase** trait which will reset the migrations for every request.

# Sample Requests

## 1, Register User

**URL :** http://127.0.0.1:8000/api/register
**Method :** POST
**Input :**
``
{
	"name":  "Vijay",
	"email":  "vijay@gmail.com",
	"password":  "12345"
}
``
 
## 2, Login User

**URL :** http://127.0.0.1:8000/api/login
**Method :** POST
**Input :**
``
{
	"email":  "vijay@gmail.com",
	"password":  "12345"
}
``
 ## 3, Create Candidate

**URL :** http://127.0.0.1:8000/api/candidates
**Method :** POST
**Input :**
``
{
    "first_name":  "Victor",
    "last_name":  "Sam",
    "email":  "sam@example.com",
    "contact_number":  "13556763",
    "gender":  1,
    "specialization":  "Computer Science",
    "work_ex_year":  "2",
    "candidate_dob":  "1997-01-30",
    "address":  "Chennai"
}
``
  ## 4, Fetch All Candidates

**URL :** http://127.0.0.1:8000/api/candidates/1
**Method :** GET

  ## 5, Fetch Candidate by ID

**URL :** http://127.0.0.1:8000/api/candidates
**Method :** GET

  ## 6. Search Candidate

**URL :** http://127.0.0.1:8000/api/candidates?first_name=victor&last_name=sam
**Method :** GET
