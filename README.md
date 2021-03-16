# Minisend

A knock-off of [MailerSend](mailersend.com/) Built with laravel, vue and little bit of passion.

![home screen](https://i.postimg.cc/ZRNffJnn/Minisend-Google-Chrome-504.jpg)
![Email details screen](https://i.postimg.cc/HLVvywCQ/Minisend-Google-Chrome-505.jpg)
![Emails to recipient screen](https://i.postimg.cc/6QgjL89F/Minisend-Google-Chrome-506.jpg)
![Add email screen](https://i.postimg.cc/Z5fDnfXb/Minisend-Google-Chrome-507.jpg)


# Getting started

## Installation

Please check the official laravel installation guide for server requirements before you start. [Official Documentation](https://laravel.com/docs/8.x/installation)


Clone the repository

    git clone git@github.com:osvaldoM/minisend.git

Switch to the repo folder

    cd minisend

Install all the dependencies using composer

    composer install

Copy the example env and env.testing files and make the required configuration changes (database, queues and smtp connection)

    cp .env.example .env && .env.testing.example


Generate a new application key

    php artisan key:generate


Run the database migrations (**Set the database connection in .env before migrating**)

    php artisan migrate

Populate the database with seed data with relationships which includes emails, statuses, attachments, etc

    php artisan db:seed

Start the local development server

    php artisan serve --port=8000


Running The Queue Worker for sending emails

    php artisan queue:work


You can now access the server at http://localhost:8000

## Login details

API/User authentication is not required

csrf token is not required

# Testing API

To test the laravel backend api

    php artisan test --parallel

Or if you have phpunit installed globally

    phpunit

----------

# Features
 - Send Email
 - View Emails for a specific recipient
 - View Email details
 - Resend failed email
 - View all emails with pagination and search
