## PHP Test

### Installation

First, [install PHP](https://www.php.net/manual/en/install.php) on your OS.

Second, clone the repository:
```cmd
git clone https://github.com/luchoweb/PHP-Test
```

Third, move to the project folder ```cd PHP-Test``` and install Laravel:

```cmd
composer.phar install
```

Fourth, rename or copy ```.env.example``` to ```.env``` and payments variables.

```txt
PAYMENT_URL=
PAYMENT_LOGIN=
PAYMENT_SECRET_KEY=
```

---

#### Set up database

---

#### Migration

Run migration ```php artisan migrate```

---

#### Ready?

Finally, run local server (--port flag is optional):
```cmd
php artisan serve --port=8080
```

Visit http://localhost:8080 or http://127.0.0.1:8080

---

#### Testing

---

That's it! Thank for you time.