# SGJ Smart Library Portal

A complete offline library management system built with PHP, MySQL, and Python tools.

## 🚀 Setup Instructions

### Prerequisites
- XAMPP/WAMP/MAMP (for PHP and MySQL)
- Python 3.7+ (for Python tools)

### Installation Steps

1. **Copy Files**
   - Copy all files to your web server directory (e.g., `htdocs/sgj_library/`)

2. **Start Services**
   - Start Apache and MySQL services in XAMPP Control Panel

3. **Initialize Database**
   - Run `http://localhost/sgj_library/init_mysql.php`
   - This will create the database and tables
   - Creates default admin user: admin@sgjlibrary.com / admin123

4. **Security Cleanup**
   - Delete `init_mysql.php` after successful initialization for security

5. **Access the System**
   - Visit `http://localhost/sgj_library/`
   - Login with default admin credentials:
     - Email: `admin@sgjlibrary.com`
     - Password: `admin123`

## 🎯 Features

### For Students
- Browse available books
- Check real-time availability
- Submit borrow requests
- View personal borrow history
- Return borrowed books

### For Admins
- Add new books to the library
- Approve/reject borrow requests
- View all system data
- Manage users and books

## 🔐 Default Credentials

- **Admin**: admin@sgjlibrary.com / admin123

## 🛠️ Database Schema

The system uses 4 main tables:
- `users`: Stores user information (students and admins)
- `books`: Contains book details and copies
- `borrow_records`: Tracks issued and returned books
- `borrow_requests`: Manages pending borrow requests

## 🐍 Python Tools Included

1. **Flask App** (`app.py`): Alternative interface
2. **Library Bot** (`library_bot.py`): WhatsApp notifications
3. **Data Analyzer** (`data_analyzer.py`): Reports and analytics
4. **Bulk Importer** (`bulk_importer.py`): CSV import functionality
5. **Templates**: Login and dashboard UI

## 📋 Security Features

- SQL injection prevention with PDO prepared statements
- CSRF token validation
- Password hashing with PHP's password_hash
- Session validation
- Input sanitization

## 📈 Available Reports

- Book availability status
- User borrowing history
- Overdue books
- Popular books

## 🤖 Python Tools Usage

1. Install requirements: `pip install -r requirements.txt`
2. Run Flask app: `python app.py`
3. Access at: `http://localhost:5000`

## 📞 Support

For issues or questions, contact the development team.