# Supplier Management System

Web Systems Technologies final project. A PHP and MySQL CRUD web app to manage suppliers and the products they provide.

## Features
- Add, view, edit, delete suppliers and products
- Search suppliers by name and filter by status
- Dashboard with totals, inventory value, and low-stock alerts
- Responsive layout with Bootstrap 5

## Tech
PHP, MySQL (mysqli with prepared statements), HTML, CSS, Bootstrap 5

## Database
Tables: suppliers, products (one supplier has many products). See database.sql.

## Run locally
1. Install XAMPP, start Apache and MySQL
2. Copy this folder to xampp/htdocs/supplier-system
3. Import database.sql in phpMyAdmin
4. Open http://localhost/supplier-system

## Deploy to InfinityFree
1. Create a MySQL database in the control panel
2. Edit db_connect.php with the hostname, username, password, database name
3. Remove the CREATE DATABASE and USE lines from database.sql, then import it in phpMyAdmin
4. Upload all files into htdocs/

## Live site
psalm-lorenz-saonoy.freepage.cc

## Author
Psalm Lorenz Sa-onoy, BSIT 3-AI
