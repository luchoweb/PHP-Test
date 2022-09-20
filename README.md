## PHP Test

### Prerequisites

- Please [install PHP](https://www.php.net/manual/en/install.php) on your OS.
- Please install [XAMP](https://www.apachefriends.org/es/download.html) or [MAMP](https://www.mamp.info/en/downloads/) to manage the database service and use PHPMyAdmin.

---

### Installation

Second, clone the repository:
```cmd
git clone https://github.com/luchoweb/PHP-Test
```

Third, move to root folder of the project ```cd PHP-Test``` and install Laravel:

```cmd
composer.phar install
```

Fourth, rename or copy ```.env.example``` to ```.env``` and add the payments variables at the end of the file.

```txt
PAYMENT_URL=
PAYMENT_LOGIN=
PAYMENT_SECRET_KEY=
```

---

#### Set up database

---

#### Migration

Make sure you're in the root folder of the project and run ```php artisan migrate```

After run ```php artisan db:seed``` for seeding products table.

---

#### Install node_modules

Make sure you're in the root folder of the project and run ```npm install```

---

#### Ready?

Finally, run ```php artisan serve``` and in another console tab run ```npm run dev```

Visit http://localhost:8000

---

#### Testing

---

That's it! Thank for you time.