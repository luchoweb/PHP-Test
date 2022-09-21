## PHP Test

### Prerequisites

- Please [install PHP](https://www.php.net/manual/en/install.php) on your OS.
- Please install [XAMP](https://www.apachefriends.org/es/download.html) or [MAMP](https://www.mamp.info/en/downloads/) to manage the database service and use PHPMyAdmin.

---

### Installation

Clone the repository:
```cmd
git clone https://github.com/luchoweb/PHP-Test
```

Move to root folder of the project ```cd PHP-Test``` and install Laravel:

```cmd
composer.phar install
```

Rename or copy ```.env.example``` to ```.env``` and add the payments variables at the end of the file.

```txt
PAYMENT_BASE_URL = 
PAYMENT_LOGIN = 
PAYMENT_SECRET_KEY =
```

---

#### Set up database

If you're using MAMP, you need to update ```DB_PASSWORD``` in your new .env file:

```txt
DB_PASSWORD = root
```

Important: make sure you MySQL port is **3306** or change ```DB_PORT``` in the .env file.

Example: 
```txt
DB_PORT = 3307
```

---

#### Migration

Make sure you're in the root folder of the project and run ```php artisan migrate```

After run ```php artisan db:seed``` for seeding products table.

---

#### Install node_modules

Make sure you're in the root folder of the project and run ```npm install```

---

#### Ready?

Open XAMP o MAMP and start the mysql service, optional start the Apache or Nginx service.

Then, run ```php artisan serve``` and in another console tab run ```npm run dev```

Visit http://localhost:8000

---

#### Testing

Coming soon

---

That's it! Thank for you time.