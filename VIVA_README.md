# SGJ College Library Management System

## Project Overview
A simple, college-level PHP/MySQL library management system for managing book borrowing and returns.

## Files Structure

### Core Files
- `index.php` - Main application file with login, book browsing, and admin functions
- `db.php` - Database connection and helper functions
- `style.css` - Simple styling for the application

### Admin Functions
- `simple_import.php` - CSV-based book import system (admin only)
- `admin_approve.php` - Handle book request approvals/rejections
- `return_book.php` - Process book returns

### Data Files
- `library_books.csv` - Sample book data in CSV format

## Key Features

### Student Features
- User registration and login
- Search books by title or author
- Request to borrow available books
- View book availability status

### Admin Features
- Import books via CSV upload
- Approve/reject borrow requests
- View pending requests dashboard
- Simple book management

## Technology Stack
- **Backend**: Pure PHP (no frameworks)
- **Database**: MySQL
- **Frontend**: HTML/CSS/JavaScript
- **Data Import**: Native PHP CSV parsing

## Installation
1. Place files in XAMPP htdocs directory
2. Create MySQL database using db.php configuration
3. Access via http://localhost/sgj%20library/

## Viva Preparation Notes
This is a standard college-level PHP/MySQL project demonstrating:
- Basic CRUD operations
- User authentication
- Form handling
- Database relationships
- File upload and processing
- Simple admin interface

All functionality is implemented using native PHP without external libraries or frameworks.