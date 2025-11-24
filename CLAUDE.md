# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

HPship is a shipping/logistics management system built with PHP and MySQL. It's a web application that handles order creation, package tracking, delivery management, and user account management for a shipping service company.

**Database Name:** `HPship`
**Server Environment:** WAMP (Windows, Apache, MySQL, PHP)
**Database Credentials:** localhost, root, no password (development environment)

## Architecture

This is a classic **MVC-style PHP application** with the following structure:

### Core Components

- **model/** - Database interaction layer (uses MySQLi and PDO)
  - `connect1.php`, `connect2.php`, `connect3.php` - Database connection classes
  - `m*.php` files - Model classes for specific domains (orders, accounts, shipping, etc.)

- **view/** - Presentation layer (PHP templates with inline HTML/CSS/JS)
  - `u_*.php` - User-facing views (customers)
  - `m_*.php` - Manager/staff views (post office staff, managers)
  - `d_*.php` - Delivery driver views

- **control/** - Business logic layer (controllers)
  - `c*.php` files - Controller classes that bridge models and views

- **API/** - REST-like endpoints for AJAX requests
  - Returns JSON data for frontend consumption
  - Used for real-time search, order tracking, and notifications

### Routing System

- **Main entry point:** `index.php`
  - Uses query parameter routing: `?page=<page_code>`
  - Example: `?page=atkbc` loads `view/u_timkiembuucuc.php`

- **Direct page access:** Many views can be accessed directly (e.g., `view/u_taoDonHang.php`)

- **URL Rewriting:** `.htaccess` enables SEO-friendly URLs
  - `/order/12345` maps to `chi_tiet_don_hang.php?maVanDon=12345`

### Authentication & Authorization

- **Session-based authentication** using PHP sessions
- Three user types stored in different session keys:
  - `$_SESSION['nguoidung']` - Regular customers
  - `$_SESSION['nvbc']` - Post office staff (Nhân viên bưu cục)
  - `$_SESSION['user']` - General authenticated users

- **Login pages:**
  - `view/dangNhap.php` - Customer login
  - `view/dangNhapNhanSu.php` - Staff login

- **Authorization checks:** Views check session variables and redirect to login if unauthorized

### Key Database Tables

Based on code analysis, important tables include:
- `taodonhang` - Order creation/drafts
- `donhang` - Active orders
- `taikhoan` - User accounts
- `buucuc` - Post office locations
- Address tables: Province (`lvl1`), District (`lvl2`), Ward (`lvl3`) hierarchy

## Development Workflow

### Running the Application

1. **Start WAMP server** (Apache + MySQL)
2. Access via browser: `http://localhost/WEBSITE_EXHIBITION/`
3. Alternatively access specific paths like: `http://localhost/WEBSITE_EXHIBITION/view/u_taoDonHang.php`

### No Build Process Required

This is a traditional PHP application - **no compilation or build step needed**. Changes to PHP/HTML/CSS/JS files are immediately reflected on page refresh.

### Testing Changes

Since there's no automated test suite, test manually:
1. Make code changes
2. Refresh browser
3. Test the affected functionality
4. Check browser console for JavaScript errors
5. Check PHP error logs in WAMP

## Common Development Tasks

### Working with Database

- **Connection pattern (MySQLi):**
  ```php
  include_once("model/connect1.php");
  $p = new connect_db();
  $conn = $p->open_kn();
  // ... use $conn
  $p->close_kn($conn);
  ```

- **Connection pattern (PDO):**
  ```php
  $pdo = new PDO("mysql:host=localhost;dbname=HPship", "root", "");
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $pdo->exec("SET NAMES utf8");
  ```

- **Always use prepared statements** for user input (already implemented in `mtaodonhang.php`)

### Creating New Features

Follow existing patterns:

1. **Model** (`model/m_newfeature.php`):
   - Create class with database operations
   - Use prepared statements for queries
   - Return data arrays or boolean results

2. **Controller** (`control/c_newfeature.php`):
   - Include model file
   - Instantiate model class
   - Handle form submissions / input validation
   - Return results to view

3. **View** (`view/u_newfeature.php`):
   - Include controller if needed
   - Check authentication/session
   - Display data using PHP embedded in HTML
   - Use AJAX for dynamic features

4. **API endpoint** (if needed) (`API/newfeatureAPI.php`):
   - Include connection class
   - Process request parameters
   - Return JSON response

### Address Hierarchy System

The application uses a 3-level address system (Province > District > Ward):
- **Sender address:** `lvl1`, `lvl2`, `lvl3` (from address)
- **Receiver address:** `lvl1_1`, `lvl2_1`, `lvl3_1` (to address)
- Cascading dropdowns implemented in `js/script.js` using Bootstrap Select
- Backend handler: `control/c_quanhuyenxaphuong.php`

### Frontend Dependencies

**CSS Frameworks:**
- Bootstrap 5.3 (primary UI framework)
- Custom fonts: Samsung One, Samsung Sharp Sans

**JavaScript Libraries:**
- jQuery 3.3.1
- Bootstrap 5.3 JS
- Bootstrap Select (for enhanced dropdowns)
- Chart.js (for analytics)
- Moment.js (date handling)
- Perfect Scrollbar

**Key JavaScript Files:**
- `js/script.js` - Main application logic (address dropdowns, form handling)
- `js/framework.js` - Core framework functionality
- `js/chart.js` - Dashboard charts

## Important Code Patterns

### Session Management

Always start session at the beginning of protected pages:
```php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
```

### Base Path Definition

For includes in nested directories:
```php
if (!defined('BASE_PATH')) {
    define('BASE_PATH', dirname(__DIR__));
}
include_once(BASE_PATH . "/control/ctaodonhang.php");
```

### API Response Format

JSON responses follow this pattern:
```php
header('Content-Type: application/json; charset=utf-8');
echo json_encode($data_array);
```

### Character Encoding

Always set UTF-8 encoding for database connections:
```php
mysqli_set_charset($conn, "utf8");
// OR
$pdo->exec("SET NAMES utf8");
```

## Security Considerations

- Database credentials are hardcoded (development only - should use environment variables in production)
- Prepared statements are used in newer code (`mtaodonhang.php`) - prefer this pattern
- Some legacy code may use string concatenation - refactor to prepared statements when modifying
- Sessions should be validated and regenerated appropriately
- Input validation should be added where missing

## File Naming Conventions

- **Prefix conventions:**
  - `u_` - User/customer facing pages
  - `m_` - Manager/staff pages
  - `d_` - Delivery driver pages
  - `c_` - Controller files
  - `m` (in model/) - Model files

- **Special files:**
  - `config.php` - Configuration constants (API base URL)
  - `chi_tiet_don_hang.php` - Order detail page (root level)
  - `index.php` - Main entry point

## Git Workflow

This project uses Git with a main branch. The README.md contains Git commands but appears to be notes rather than documentation.

## Notes

- This is a Vietnamese language application (all UI text is in Vietnamese)
- The project appears to be actively developed (recent git activity)
- There are some test/debug files present (`view/debug_address.php`, various `test*.php` in API/)
- PHPMailer library is included for email functionality
