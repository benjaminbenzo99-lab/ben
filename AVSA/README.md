# AVSA NGO Platform

A full-stack PHP 8 + MySQL NGO website for AVSA.

## Local setup with XAMPP

1. Install XAMPP and start Apache and MySQL.
2. Copy this project into `C:/xampp/htdocs/AVSA`.
3. Create the database in MySQL using the SQL file:
   - Open phpMyAdmin
   - Import `database/database.sql`
4. Copy `.env.example` to `.env` and update credentials.
5. Open `http://localhost/AVSA` in your browser.
6. Log into the admin area using the first admin account you create.

## Important notes

- The site is built as a working full-stack PHP application with MySQL-backed content.
- The project includes content management, donation forms, contact forms, gallery uploads, search, and admin features.
- Database passwords and secrets should be kept in `.env` and never exposed publicly.

## Deployment

- Upload the project to a production host with PHP 8 and MySQL 8.
- Configure Apache or Nginx to point to the public directory.
- Enable SSL via Let's Encrypt or your hosting provider.
- Set production environment values in the server environment or `.env`.
