# Zettlr

*A Zettelkasten implementation with Laravel 5*

**Currently in beta - please feel free to test and give feedback :-)**

## About

Zettlr is an app, that is specifically designed for people that write texts and need to structure their thoughts, cite papers and books or just need to work with their notes a little bit more than sticking them to the fridge. Zettlr is not just another notebook application, but a full fledged analysis tool, that helps you organize, analyze and write texts fast and efficiently.

With Zettlr you can …

* … store a huge amount of notes, add literature references and tag them
* … discover previously unknown connections between notes based on tags
* … insert notes with pre-assigned tags and references so that you can insert notes even faster
* … use outlines to gather notes, add your personal notes and arrange them any way you like

[Visit the homepage](http://www.zettlr.com)

## Install

Zettlr is still under heavy development. It is not recommended for use in production yet. If you want to test it, please make sure to regularly backup your database in case some unwanted behavior by the app results in loss of data.

To install, first navigate to the desired location and clone the repository:

```
$ git clone https://github.com/nathanlesage/Zettlr
```

Then install the project dependencies via composer:

```
$ cd Zettlr
$ composer install
```

When composer has finished, migrate the databases and seed the admin account:

```
$ touch database/database.sqlite
$ php artisan migrate
$ php artisan db:seed
```

The `touch`-command is because Artisan has a bug that prevents it from automatically creating the database-file. Of course, if you want to use another database type, edit the following line in `config/database.php`:

```
'default' => env('DB_CONNECTION', 'sqlite'),
```

and change `sqlite` to anything listed in the `connections`-array. Don't forget to provide additional credentials!

The next step is creating the `.env`-file and generate a secure cipher:

```
$ cp .env.example .env
$ php artisan key:generate
```

If your local domain (or, if you plan to publish the installation) varies from http://localhost, provide the correct string in the `.env`-file in the `APP_URL`-variable. If you don't the LESS-compiler will give a wrong path to the final CSS-file. In case you already created one, you can always delete the stylesheet (located in `public/css/app.min.css`). The compiler will notice this and recreate it automatically.

If you are done, set the application to production and start your server.

```
$ php artisan up
$ php artisan serve
```

The default credentials are `test@example.com` and `admin`. Please make sure you change the password immediately using the settings pane under `http://your-zettlr-installation.com/settings`

## License

This software is licensed under the terms of the [MIT License](https://opensource.org/licenses/MIT).
