# Laundry Management System

A comprehensive, production-ready laundry management system built with CodeIgniter PHP framework, featuring multi-user access, mobile app integration, barcode tracking, and complete business management capabilities.

## 🚀 Features

### 📱 Multi-Platform Access
- **Web Admin Portal**: Complete administrative dashboard
- **Customer Web Portal**: Self-service order tracking and management
- **Flutter Mobile App**: Native mobile app for customers and drivers
- **Point of Sale (POS)**: Quick order creation interface

### 🏷️ Advanced Order Management
- **Barcode System**: Automated barcode generation and tracking
- **Photo Documentation**: Pickup and delivery photo evidence
- **Order Tracking**: Real-time status updates (neworder → pending → wash_ready → delivered)
- **Invoice Generation**: Automated invoice numbering and management
- **Delivery Scheduling**: Flexible pickup and delivery date management

### 👥 Multi-User System
- **Administrators**: Full system access and business management
- **Employees**: Role-based access for order processing
- **Drivers/Delivery Staff**: Mobile app for route management
- **Customers**: Web and mobile access for order management
- **Multi-Store Support**: Chain management capabilities

### 🧾 Business Management
- **Garment Management**: Comprehensive garment type and attribute tracking
- **Service Categories**: Wash & Iron, Dry Clean, custom services
- **Dynamic Pricing**: Configurable pricing based on garment type and service
- **Financial Tracking**: Payment processing, discounts, and expense management
- **Reporting & Analytics**: Business intelligence and performance metrics

### 📞 Communication System
- **Bulk Messaging**: SMS and WhatsApp integration
- **Email Notifications**: Automated order confirmations and updates
- **Multi-language Support**: English, Chinese, Portuguese, Russian, Bengali
- **OTP Authentication**: Secure mobile number verification

## 🛠️ Technology Stack

- **Backend**: CodeIgniter 3.x (PHP MVC Framework)
- **Database**: MySQL/MariaDB
- **Frontend**: Bootstrap 4, jQuery, HTML5/CSS3
- **Mobile**: Flutter (REST API integration)
- **Server**: Apache/Nginx compatible
- **PHP Version**: 5.6+ (7.4+ recommended)

## 📁 Project Structure

```
laundry-management-system/
├── application/               # CodeIgniter application files
│   ├── controllers/          # MVC Controllers
│   │   ├── Admin.php        # Administrative functions
│   │   ├── Customer.php     # Customer portal
│   │   ├── Pos.php          # Point of Sale system
│   │   ├── Flutter.php      # Mobile API endpoints
│   │   └── ...
│   ├── models/              # Data models
│   ├── views/               # View templates
│   └── config/              # Configuration files
├── assets/                  # Static assets (CSS, JS, images)
├── barcode/                 # Generated barcode images
├── pickup_photo/            # Pickup documentation photos
├── delivery_photo/          # Delivery proof photos
├── dbase/                   # Database schemas and dumps
├── system/                  # CodeIgniter system files
└── index.php               # Application entry point
```

## ⚙️ Installation

### Prerequisites
- PHP 7.4+ (minimum 5.6)
- MySQL 5.7+ or MariaDB 10.2+
- Apache/Nginx web server
- Composer (optional, for dependencies)

### Quick Setup

1. **Clone the repository**
   ```bash
   git clone https://github.com/hunterxcobby/laundry-management-system.git
   cd laundry-management-system
   ```

2. **Configure the database**
   ```bash
   # Import the database schema
   mysql -u username -p database_name < dbase/laundry.sql
   ```

3. **Update configuration**
   ```php
   // application/config/database.php
   $db['default'] = array(
       'hostname' => 'localhost',
       'username' => 'your_username',
       'password' => 'your_password',
       'database' => 'your_database_name',
       // ... other settings
   );
   ```

4. **Set base URL**
   ```php
   // application/config/config.php
   $config['base_url'] = 'http://your-domain.com/';
   ```

5. **Set permissions**
   ```bash
   chmod -R 755 application/
   chmod -R 777 application/logs/
   chmod -R 777 barcode/
   chmod -R 777 pickup_photo/
   chmod -R 777 delivery_photo/
   ```

## 🔒 Security & Configuration Management

### Sample Configuration Files
For security reasons, sensitive configuration files are not included in the repository. Instead, sample template files are provided:

- `application/config/database.sample.php` - Database configuration template
- `application/config/config.sample.php` - Main configuration template  
- `application/config/constants.sample.php` - Constants template

### Setting Up Configuration Files

1. **Copy sample files to actual config files:**
   ```bash
   cp application/config/database.sample.php application/config/database.php
   cp application/config/config.sample.php application/config/config.php
   cp application/config/constants.sample.php application/config/constants.php
   ```

2. **Update the copied files with your actual values:**
   - Database credentials
   - Base URL
   - API keys and secrets
   - Environment-specific settings

### What's Protected
The following files are excluded from version control via `.gitignore`:
- `application/config/database.php` - Contains database credentials
- `application/config/config.php` - Contains base URL and secrets
- `application/logs/` - Application log files
- `barcode/` - Generated barcode images
- `pickup_photo/` - Customer pickup photos
- `delivery_photo/` - Delivery proof photos

### Database Setup Notes
Due to MySQL compatibility issues with CodeIgniter 3.x and MySQL 8.0+:

1. **Create a dedicated database user** (recommended over using root):
   ```sql
   CREATE USER 'laundry_dev'@'localhost' IDENTIFIED BY 'your_password';
   CREATE DATABASE laundry_local;
   GRANT ALL PRIVILEGES ON laundry_local.* TO 'laundry_dev'@'localhost';
   FLUSH PRIVILEGES;
   ```

2. **Disable MySQL strict mode** if encountering GROUP BY errors:
   ```sql
   SET GLOBAL sql_mode = '';
   ```

3. **Import the database:**
   ```bash
   mysql -u laundry_dev -p laundry_local < dbase/laundry.sql
   ```

For detailed database troubleshooting, see: `docs/DATABASE_TROUBLESHOOTING.md`

### Default Login Credentials

**Admin Panel:**
- Username: `admin`
- Password: Check database or contact administrator

**Demo Customer:**
- Use mobile number for OTP-based login (OTP disabled in demo)

## 🚀 Usage

### Admin Dashboard
1. Access: `http://your-domain.com/index.php/admin`
2. Features:
   - Order management and tracking
   - Customer and employee management
   - Pricing and service configuration
   - Reports and analytics
   - System settings

### Customer Portal
1. Access: `http://your-domain.com/index.php/customer`
2. Features:
   - Place new orders
   - Track existing orders
   - View order history
   - Update profile information

### Point of Sale (POS)
1. Access: `http://your-domain.com/index.php/pos`
2. Features:
   - Quick order creation
   - Barcode generation
   - Real-time pricing
   - Payment processing

### Mobile API
- Base URL: `http://your-domain.com/index.php/flutter`
- Authentication: Mobile OTP verification
- Features: Full customer and driver functionality

## 📊 Database Schema

### Key Tables
- `customer_order` - Main order management
- `order_temp` - Temporary order processing
- `users` - Customer management
- `admin` - Administrative users
- `employee` - Staff management
- `price_list` - Service pricing
- `cloths` - Garment types
- `barcode_data` - Barcode tracking
- `settings` - System configuration

## 🔧 Configuration

### Environment Settings
```php
// application/config/config.php
$config['base_url'] = 'http://your-domain.com/';
$config['index_page'] = 'index.php';
$config['language'] = 'english';
```

### Database Configuration
```php
// application/config/database.php
$db['default'] = array(
    'dsn' => '',
    'hostname' => 'localhost',
    'username' => 'db_username',
    'password' => 'db_password',
    'database' => 'db_name',
    'dbdriver' => 'mysqli',
    // ... other settings
);
```

## 🔄 Business Workflows

### Order Processing Flow
1. **Order Creation** → POS/Web/Mobile
2. **Garment Collection** → Photo documentation
3. **Service Processing** → Washing/Cleaning
4. **Quality Check** → Defect tracking
5. **Delivery** → Photo proof and completion

### Customer Journey
1. **Registration** → Mobile OTP verification
2. **Order Placement** → Service and garment selection
3. **Tracking** → Real-time status updates
4. **Communication** → SMS/Email notifications
5. **Delivery** → Confirmation and feedback

## 🌐 Multi-Language Support

Supported languages:
- English (default)
- Chinese
- Portuguese
- Russian
- Bengali

Language files located in: `application/language/`

## 📱 Mobile App Integration

### Flutter API Endpoints
- `POST /flutter/chkCustomerMobile` - Customer authentication
- `GET /flutter/customerDetails` - Customer information
- `POST /flutter/ordersList` - Order management
- Driver-specific endpoints for pickup/delivery

### Authentication
- OTP-based mobile verification
- Session management
- Role-based access control

## 🛡️ Security Features

- SQL injection protection (CodeIgniter Active Record)
- XSS filtering
- CSRF protection
- Session security
- Input validation and sanitization
- File upload security

## 🔍 Troubleshooting

### Common Issues

1. **Database Connection Error**
   - Check database credentials in `application/config/database.php`
   - Ensure MySQL service is running
   - **Note**: See `docs/DATABASE_TROUBLESHOOTING.md` for detailed MySQL setup issues and solutions

2. **Configuration Files Missing**
   - Copy sample files: `cp application/config/*.sample.php application/config/`
   - Update with your actual credentials and settings
   - Ensure `.gitignore` is protecting sensitive files

3. **Permission Denied**
   - Set proper file permissions: `chmod -R 755 application/`
   - Ensure web server has write access to logs and upload directories

3. **Base URL Issues**
   - Update `$config['base_url']` in `application/config/config.php`
   - Check .htaccess configuration

4. **Mobile API Not Working**
   - Verify Flutter controller accessibility
   - Check JSON output format
   - Ensure proper headers are set

## 📈 Performance Optimization

- Database indexing on frequently queried fields
- Image compression for barcode and photo storage
- Caching for frequently accessed data
- Optimized SQL queries
- Asset minification and compression

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch: `git checkout -b feature-name`
3. Commit changes: `git commit -am 'Add feature'`
4. Push to branch: `git push origin feature-name`
5. Submit a pull request

## 📄 License

This project is licensed under the MIT License - see the [LICENSE](license.txt) file for details.

## 🆘 Support

For support and questions:
- Create an issue on GitHub
- Check the documentation in `/docs/` (if available)
- Review the codebase comments and inline documentation

## 📚 Additional Documentation

- [Database Troubleshooting Guide](docs/DATABASE_TROUBLESHOOTING.md) - MySQL setup issues and solutions
- [MySQL Issues Summary](MYSQL_ISSUES_SUMMARY.md) - Quick reference for database problems
- [Development Guidelines](.copilot-rules.md) - Coding standards and best practices
- [Contributing Guidelines](contributing.md) - How to contribute to the project

---

**Built with ❤️ for laundry businesses worldwide**

*Last updated: September 2025*