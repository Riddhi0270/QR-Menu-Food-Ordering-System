# A Digital QR-Based Menu & Food Ordering System
## Mini Project Report — TY B.Sc. Computer Science

**Student Name:** ____________________  
**Roll Number:** ____________________  
**College:** ____________________  
**Guide:** ____________________  
**Academic Year:** ____________________

## 1. Abstract
The Digital QR-Based Menu & Food Ordering System is a web application designed to make restaurant ordering simple and efficient. Customers can open a digital menu, view food items and prices, add items to a cart, calculate the total bill, and place an order by entering their name and table number. The administrator can log in, view orders, update order status, and manage menu availability. The application uses HTML, CSS and JavaScript for the user interface, PHP for server-side processing, and MySQL for storing menu items and orders.

## 2. Introduction
Traditional restaurant ordering often depends on printed menus and manual communication. A QR-based digital menu allows customers to access menu details from a browser. This project demonstrates the basic workflow of digital menu viewing and food ordering.

## 3. Problem Statement
Printed menus can become outdated and order details may be recorded manually. A simple digital system is required to show current menu information and store customer orders in a database.

## 4. Objectives
- To display restaurant menu items digitally.
- To allow customers to add food to a cart.
- To calculate order totals automatically.
- To save orders and order details in a database.
- To provide an admin login and order management panel.
- To test the application and document its functionality.

## 5. Scope
This educational prototype supports menu browsing, cart, order placement, basic admin authentication, menu availability management, and order status updates. Online payment, delivery tracking, and production-grade multi-restaurant support are outside the current scope.

## 6. Hardware and Software Requirements
**Hardware:** Laptop/desktop, 4 GB RAM recommended, internet for downloading software/GitHub.  
**Software:** Windows, XAMPP, Apache, PHP, MySQL, browser, code editor, Git/GitHub (for source control).

## 7. Technology Used
- HTML: page structure
- CSS: styling and responsive layout
- JavaScript: cart interactions and client-side checks
- PHP: server-side logic and form handling
- MySQL: persistent data storage
- GitHub: source code repository and version control

## 8. System Modules
### Customer Module
Displays available menu items, prices, categories, quantity selection, cart, total amount, customer name, table number and order confirmation.

### Admin Module
Provides login, order list, order detail, order status update, menu item addition/deletion and availability toggle.

### Database Module
Tables: `admins`, `menu_items`, `orders`, and `order_items`.

## 9. System Design
### Data flow
1. Customer opens the digital menu through a URL/QR code.
2. Application retrieves available menu items from MySQL.
3. Customer adds items to the cart and submits an order.
4. PHP validates submitted IDs and quantities against database values.
5. Order and order items are saved to MySQL.
6. Admin logs in and updates order status.

### Database relationships
- One order can contain many order_items.
- One menu_item can appear in many order_items.
- Admin accounts are stored separately with password hashes.

## 10. Implementation
The frontend is built using HTML, CSS and JavaScript. PHP handles order submission and admin operations. MySQL stores food items, orders and order lines. Prepared statements are used for database operations. The admin password is stored as a hash.

## 11. Testing
Run the following tests and record the actual result after testing. Do not mark tests as passed until you have tried them.

| Test ID | Test case | Expected result | Actual result |
|---|---|---|---|
| TC01 | Open customer menu | Available food items are displayed | ______ |
| TC02 | Add one item to cart | Item and subtotal appear | ______ |
| TC03 | Change quantity | Cart total updates correctly | ______ |
| TC04 | Place valid order | Order number and total are displayed | ______ |
| TC05 | Place order with empty cart | Order is rejected | ______ |
| TC06 | Admin login with correct credentials | Dashboard opens | ______ |
| TC07 | Admin login with wrong password | Error message appears | ______ |
| TC08 | Admin updates order status | New status is saved | ______ |
| TC09 | Admin adds a menu item | Item appears in menu management | ______ |
| TC10 | Admin marks item unavailable | Item no longer appears on customer menu | ______ |

## 12. Security and Validation
The application validates required fields and quantity limits, checks item availability on the server, uses prepared SQL statements, escapes displayed data, hashes admin passwords, regenerates the session ID on login, and uses CSRF tokens for admin POST forms. This is a learning prototype and needs additional hardening before real-world use.

## 13. Deployment
For the demonstration, the app can run locally using XAMPP. Copy the folder into `htdocs`, start Apache and MySQL, import `database.sql` in phpMyAdmin, create the admin account using the setup page, and open the local URL. For public access, deploy to a PHP/MySQL hosting provider and configure credentials securely. Localhost QR codes are not accessible from other devices.

## 14. Limitations
- No online payment gateway.
- Localhost version is only available on the same computer.
- No email/SMS notifications.
- Not designed for heavy production traffic.
- Demo admin password should be changed before public deployment.

## 15. Future Enhancements
- Online payment integration
- Customer order history and live status tracking
- QR code for each table
- Food images and reviews
- Sales reports and analytics
- Multi-restaurant support

## 16. Conclusion
The project demonstrates how a QR-accessible digital menu can simplify menu browsing and order placement. It combines frontend development, backend processing, database integration, validation, admin functions, testing, and documentation.

## 17. References
- PHP Documentation: https://www.php.net/docs.php
- MySQL Documentation: https://dev.mysql.com/doc/
- MDN Web Docs: https://developer.mozilla.org/
- GitHub Docs: https://docs.github.com/

## Screenshots to add
1. Customer menu page
2. Cart with selected items and total
3. Order confirmation page
4. Admin login page
5. Admin dashboard showing orders
6. Menu management page
7. GitHub repository page
