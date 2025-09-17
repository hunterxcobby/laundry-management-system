###################
Laundry Management System
###################

A comprehensive, production-ready laundry management system built with CodeIgniter PHP framework, featuring multi-user access, mobile app integration, barcode tracking, and complete business management capabilities.

This system is designed for laundry businesses of all sizes, from single stores to multi-location chains.

*******************
Release Information
*******************

This repository contains the complete laundry management system with the following components:

- **Web Admin Portal**: Complete administrative dashboard
- **Customer Web Portal**: Self-service order tracking and management  
- **Flutter Mobile App**: Native mobile app for customers and drivers
- **Point of Sale (POS)**: Quick order creation interface
- **REST API**: Mobile app integration endpoints

**************************
Key Features
**************************

🏷️ **Advanced Order Management**
- Barcode system with automated generation and tracking
- Photo documentation for pickup and delivery
- Real-time order tracking (neworder → pending → wash_ready → delivered)
- Automated invoice generation and management
- Flexible pickup and delivery scheduling

👥 **Multi-User System**
- Administrators with full system access
- Employees with role-based access
- Drivers/Delivery staff with mobile app access
- Customers with web and mobile access
- Multi-store support for chain management

🧾 **Business Management**
- Comprehensive garment type and attribute tracking
- Service categories (Wash & Iron, Dry Clean, custom services)
- Dynamic pricing based on garment type and service
- Financial tracking with payment processing
- Reporting and analytics dashboard

📞 **Communication System**
- Bulk messaging via SMS and WhatsApp
- Automated email notifications
- Multi-language support (English, Chinese, Portuguese, Russian, Bengali)
- OTP authentication for mobile users

*******************
Server Requirements
*******************

- PHP version 7.4 or newer is recommended
- MySQL 5.7+ or MariaDB 10.2+
- Apache/Nginx web server
- PHP extensions: mysqli, gd, curl, mbstring

It should work on PHP 5.6 as well, but we strongly advise you NOT to run
such old versions of PHP, because of potential security and performance
issues, as well as missing features.

************
Installation
************

1. **Clone or download** the repository to your web server directory

2. **Database Setup**:
   
   - Create a new MySQL database
   - Import the database schema from ``dbase/laundry.sql``
   - Update database configuration in ``application/config/database.php``

3. **Configuration**:
   
   - Set your base URL in ``application/config/config.php``
   - Configure email settings for notifications
   - Set up file permissions for upload directories

4. **File Permissions**:
   
   .. code-block:: bash
   
      chmod -R 755 application/
      chmod -R 777 application/logs/
      chmod -R 777 barcode/
      chmod -R 777 pickup_photo/
      chmod -R 777 delivery_photo/

5. **Default Login**:
   
   - Admin Username: ``admin``
   - Password: Check database or contact administrator

*******
Usage
*******

**Admin Dashboard**
  Access via ``/index.php/admin`` for complete system management

**Customer Portal**  
  Access via ``/index.php/customer`` for order management

**Point of Sale**
  Access via ``/index.php/pos`` for quick order creation

**Mobile API**
  Base URL: ``/index.php/flutter`` for mobile app integration

*******
License
*******

This project is licensed under the MIT License - see the `license.txt` file for details.

*********
Technology Stack
*********

- **Backend**: CodeIgniter 3.x (PHP MVC Framework)
- **Database**: MySQL/MariaDB  
- **Frontend**: Bootstrap 4, jQuery, HTML5/CSS3
- **Mobile**: Flutter (REST API integration)
- **Server**: Apache/Nginx compatible

*********
Project Structure
*********

.. code-block::

   laundry-management-system/
   ├── application/          # CodeIgniter application files
   │   ├── controllers/      # MVC Controllers  
   │   ├── models/          # Data models
   │   ├── views/           # View templates
   │   └── config/          # Configuration files
   ├── assets/              # Static assets (CSS, JS, images)
   ├── barcode/             # Generated barcode images
   ├── pickup_photo/        # Pickup documentation photos
   ├── delivery_photo/      # Delivery proof photos
   ├── dbase/               # Database schemas and dumps
   └── system/              # CodeIgniter system files

*********
Resources
*********

-  `Main Documentation <README.md>`_
-  `Coding Standards <.copilot-rules.md>`_
-  `Database Schema <dbase/>`_

For detailed installation instructions, API documentation, and development guidelines, 
please refer to the main `README.md` file.

***************
Support
***************

For support and questions:

- Create an issue on the GitHub repository
- Check the comprehensive documentation in ``README.md``
- Review the coding standards in ``.copilot-rules.md``
- Examine the codebase comments and inline documentation

This laundry management system is designed to be scalable, secure, and user-friendly 
for laundry businesses worldwide.

***************
Acknowledgement
***************

Built with the CodeIgniter framework and designed specifically for laundry business 
operations. Special thanks to all contributors and the open-source community.

