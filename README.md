#WEBSITE LOGIN
username -admin_reign 
password -Admin123!



# SwiftPOS — TFA4 Sessions and Authentication

This CodeIgniter 4 project extends the supplied TFA3 POS application. It retains the dashboard, customer and staff forms, validation, sample data, and staff avatar uploads. TFA4 adds staff login, server-side sessions, a route filter protecting every customer and user account page, and logout.

## Requirements

- PHP 8.2+, Composer 2, MySQL/MariaDB
- PHP extensions required by CodeIgniter (`intl`, `mbstring`, `mysqli`); `gd` for the existing avatar feature; `sqlite3` for the bundled database tests
- A MySQL database named `swiftpos`, or change its name in `.env`

## Install into an empty database

1. In the project directory, run `composer install`.
2. Copy `env` to `.env` and adjust `app.baseURL` and the `database.default.*` settings for your machine. Do not commit `.env`.
3. Create an empty database:

   ```sql
   CREATE DATABASE swiftpos CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   ```

4. Choose **one** setup method:

   **Migrations and sample seeders:**

   ```bash
   php spark migrate
   php spark db:seed DatabaseSeeder
   ```

   The staff seeder prints a different random temporary password for each user. Save the passwords privately when the command runs; they are not stored as plain text. The database stores `password_hash()` output in `users.password`.

   **Bundled SQL export:**

   ```bash
   mysql -u YOUR_DATABASE_USER -p swiftpos < database/swiftpos.sql
   php spark db:seed ResetUserPasswordsSeeder
   ```

   The export **drops and recreates** the two application tables. Use it only for a new or disposable database. Its sample staff hashes come from the TFA3 export; the explicit reset prints fresh random credentials you can use to sign in. An SQL import does not mark CodeIgniter migrations as run, so do not run `php spark migrate` over that import.

5. Run `php spark serve` and open `http://localhost:8080/login`. Use a username and temporary password printed during setup. Staff can change passwords on the **Staff Accounts → Edit** page. Log out from the navigation bar.

The dashboard (`/`) and About page (`/about`) remain public. The filter guards both customer and staff account lists, new forms, edit forms, and create/update actions. Automatic routing is disabled in `app/Config/Routing.php` so a second controller URL cannot bypass these routes. Login and logout are POST-protected with CodeIgniter's existing global CSRF filter; logout is POST only.

## Upgrade an existing TFA3 database

**If its tables were created by CodeIgniter migrations:** back up the database and run `php spark migrate`. The new `UseUserPassword` migration renames `users.password_hash` to `users.password` while preserving every existing hash. Existing user passwords continue to work. Do not rerun `DatabaseSeeder` on a populated database.

**If its tables were imported from a TFA3 SQL export:** back up the database and apply this one-time SQL change instead of running all migrations over the imported tables:

```sql
ALTER TABLE users CHANGE COLUMN password_hash password VARCHAR(255) NOT NULL;
```

The old migration history does not exist after a raw SQL import. Starting the full migration chain would attempt to recreate tables already present. The new export supplied here already has the `password` column; do not rename it again.

If you do not know the existing staff passwords, run `php spark db:seed ResetUserPasswordsSeeder` **once** from the command line. It intentionally replaces every staff password with a new random value, prints the temporary credentials, and leaves customer passwords unchanged. Keep the output private. Do not run it when you want existing credentials preserved.

## Files changed for TFA4

| File | Purpose |
| --- | --- |
| `app/Database/Migrations/2026-10-06-000001_UseUserPassword.php` | Rename the existing hash column without losing user data |
| `app/Controllers/Auth.php`, `app/Views/auth/login.php` | Verify a stored hash, regenerate and populate the session, destroy it on logout |
| `app/Filters/AuthFilter.php`, `app/Config/Filters.php`, `app/Config/Routes.php` | Guard every customer and staff route and redirect signed-out visitors |
| `app/Models/UserModel.php`, `app/Controllers/Users.php` | Save new/changed staff passwords in the migrated column using `password_hash()` |
| `app/Database/Seeds/UserSeeder.php`, `ResetUserPasswordsSeeder.php` | Create initial random credentials or explicitly reset unknown credentials |
| `database/swiftpos.sql` | Fresh-install MySQL export with the migrated user schema |
| `scripts/smoke_auth.py` | Browser-level check for login, protected routes, and logout |

TFA3's customer password column remains `customers.password_hash`. The TFA4 staff login checks the `users` table only. User roles, attendance, and verification are displayed as before; all authenticated staff can use the account management pages because this assessment specifies authentication, not role authorization.

## Verify access control

With a staff account created and `php spark serve` running, use Python 3 to test the same URLs through a browser-style cookie jar:

```bash
SWIFTPOS_TEST_USERNAME='your_username' SWIFTPOS_TEST_PASSWORD='your_password' \
  python3 scripts/smoke_auth.py http://localhost:8080/
```

The script checks that signed-out visits to customer/user lists and new/edit forms redirect to login; an incorrect password fails; a correct password gives access; and logout removes that access. It does not change database records. Set the two environment variables in your shell's usual manner on Windows. Run the existing PHP suite separately with `composer test` (requires Composer dependencies and PHP extensions).

To confirm hashes, create a staff user in the protected user form and inspect the `users.password` column in the database: it should contain a hash, and `password_verify()` should accept the chosen password. Check that editing a user with the password left blank retains the original hash. Test invalid form data and a valid JPG/PNG avatar on the user edit page to verify the existing TFA3 functions.

## Hosting and submission

Point the web server's document root at `public/`; configure HTTPS, the production base URL, and production MySQL credentials through `.env` or environment variables on the host. Give the web server write access to `writable/` and `public/uploads/avatars/`. Set secure cookies and HTTPS for the deployed environment (`cookie.secure = true` and `app.forceGlobalSecureRequests = true` with working TLS). Upload images are stored separately from the SQL export. Do not deploy the old sample accounts with known passwords; reset them first and change their temporary passwords after logging in.

Commit the project files, migrations, seeders, export, tests, and README to your GitHub repository. Keep `.env`, real credentials, and uploaded images out of the repository. Provide the repository URL and working hosted URL in your submission when those external destinations are available.

- GitHub repository: **add your repository URL**
- Hosted application: **add your deployment URL**
