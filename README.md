# Vacation Manager app

An app for vacation request are divided into three modules:

    Admin module
    Manager module
    Employee module

Admin Module details:

    Admin can view dashboard.
    Admin can update user profile info.
    Admin can add/update/delete department.
    Admin can add/update/delete employee info.
    Admin can manage the vacation request(approve and not approve).
    Admin can view the vacation request history.
    Every time when an employee send vacation request, admin will get a notification.

Manager Module details:

    Manager can view dashboard.
    Manager can update user profile info.
    Manager can manage the vacation request(approve and not approve) in his/her department.
    Manager can view the vacation request history of his/her department.
    Every time when an employee send vacation request, manager will get a notification.

Employee Module:

    Employee can view dashboard.
    Employee can update user profile info.
    Employee can send vacation request.
    Employee can view his/her vacation request history.
    Every time when an manager/admin approve or not approve vacation request employee will get a notification.

## Usage

### Clone GitHub repo for this project locally

```
git clone https://github.com/Bernard-Jelinic/vacation_manager.git
```

### cd into your project

```
cd vacation_manager
```

### Install Composer Dependencies

```
composer install
```

### Create a copy of your .env file

```
copy .env.example .env or cp .env.example .env
```

### Generate an app encryption key

```
php artisan key:generate
```

### Create an empty database for our application

Create an empty database for your project using the database tools you prefer.
Just create an empty database here, the exact steps will depend on your system setup.

### In the .env file, add database information to allow Laravel to connect to the database

We will want to allow Laravel to connect to the database that you just created in the previous step. To do this, we must add the connection credentials in the .env file and Laravel will handle the connection from there.

In the .env file fill in the DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, and DB_PASSWORD options to match the credentials of the database you just created. This will allow us to run migrations and seed the database in the next step.

### Install Pusher Channels

Create a Pusher account, if you have not already.
When Composer is done, we will need to configure Laravel to use Pusher as its broadcast driver, to do this, open the .env file that is in the root directory of your Laravel installation. Update the values to correspond with the configuration below:

```
BROADCAST_DRIVER=pusher

// Get the credentials from your pusher dashboard
PUSHER_APP_ID=XXXXX
PUSHER_APP_KEY=XXXXXXX
PUSHER_APP_SECRET=XXXXXXX
```

### Migrations

To create all the nessesary tables and columns, run the following

```
php artisan migrate
```

### Seeding The Database

To add the dummy departments, users and vacations, run the following

```
php artisan db:seed
```

### Running Then App

Upload the files to your document root, Valet folder or run

```
php artisan serve
```

## License

The Vacation Manager app is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
