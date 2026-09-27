# PHP-Password-Encrypter
# Kryptos Password Encrypter

A custom PHP password-protection system — an HTML form + PHP handler that takes
user registration data and stores it in MySQL using a custom encryption/hashing
function (salting + polyalphabetic cipher + layered hashing).

## About
Two-part project: an HTML form collects user registration data, and a PHP handler
(`Crypt.php`) processes it through `kryptosEncrypt()` — a custom function combining
a random salt, a keyword-based polyalphabetic shift cipher, and layered hashing
(SHA-256 → Whirlpool) — before inserting the result into a MySQL database.

## Tech Stack
- Language: PHP
- Database: MySQL (via `mysqli`)
- Hashing: SHA-256, Whirlpool
- Frontend: Plain HTML form

## How it works
1. User submits ID, username, and password via an HTML form
2. `Crypt.php` receives the POST data and calls `kryptosEncrypt()`:
   - Generates an 8-character random salt
   - Prepends it to the password
   - Runs the result through a keyword-based shift cipher
   - Hashes the output with SHA-256, then re-hashes with Whirlpool
   - Randomly injects symbols into the final hash (~25% chance per character)
3. Resulting hash, salt, and user info are inserted into the `USERS` table using
   a prepared statement

## Fixed issues
- **SQL injection** — original insert used raw string concatenation; rewritten
  with prepared statements (`mysqli_prepare` + `bind_param`)
- **Variable mismatch bug** — handler referenced an undefined `$password` variable
  instead of the actual POST value
- **Broken `require` path** — pointed to a nonexistent nested subfolder instead of
  the correct relative path

## Note
This is a one-way transformation, not reversible encryption — there's no decrypt
function. Best thought of as a custom password-hashing scheme rather than
"encryption" in the reversible sense.

## Status
Personal project — since patched for SQL injection and a couple of runtime bugs
found while testing.
