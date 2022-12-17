# About Project
this project created because of testing for netbina company
project consist two part:
## front end
front end created by vue js
## back end 
create by laravel 9.43.0 version (rest api)

## prepare backend project
1-you will install composer via:
```bash
composer install
```
2-If you have not copied the .env.example file to a new file named .env, you should do that now

3- for testing project please copy .env.testing.example fine to a new file named .env.testing, you should do that now

4-set Application Key
```bash
php artisan key:generate
```
5-migrate and seed database
```bash
php artisan migrate:fresh --seed
```

6-install passport via:
```bash
php artisan passport:install
```

## prepare frontend project
1-install npm via 
```bash
npm install
```
## run project
1-after seed database some user created by faker and two user specifically created for login and work with system:
user1:
email:netbina@m.com
password:123456
user2:
email:milad@m.com
password:123456

2-enter below commands
```bash
npm run dev
```

```bash
php artisan serve
```
3-enter address that php artisan serve command offers you

4-for check deadline time , I write schedule task for every day to check deadline expiration task and if expire change it to delayed, you can test it with below command:
(for check this, in seeder I create and assign tasks with expired deadline date to users after run below command will all status of this task changed to delay and change status in front)
```bash
 php artisan schedule:test
```
10- I created feature test for this system after copy env.testing.example to env.testing and migrate this , you can run it via:
```bash
 php artisan test
```

