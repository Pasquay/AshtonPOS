# Point-of-Sale (POS) System

## Overview
This is a comprehensive Point-of-Sale (POS) web application designed for businesses to efficiently manage their day-to-day operations. The system combines features such as employee management, inventory tracking, and transaction processing to deliver an all-in-one solution for retail businesses.

## Key Features
### 1. Employee Login
- Secure login system for employees.
- Passwords are securely hashed for added security.

### 2. Role-Based Access Control
- Different access levels for `Manager` and `Employee`.
- Feature access is restricted based on user roles to ensure data security.

### 3. POS Transaction System
- Streamlined sales transaction management.
- Records transaction details for accurate reporting and analytics.

### 4. Inventory Management
- Keep track of stock levels and update inventory in real-time.
- Alerts for low stock items to prevent shortages.

### 5. Employee Management
- Manage employee details including salaries and roles.
- Add, update, and delete employee records with ease.

### 6. Employee Attendance Tracking & Shift Management
- Log employee attendance in real-time.
- Track shifts and verify if they are complete or incomplete.
- Helps ensure proper employee shift allocation.

### 7. Sales & Employee Statistics
- Statistics for insightful sales and employee data.
- Displayed in easy to understand graphs.

## Database Structure
The system uses robust database management for efficient data handling, with the following key tables:

1. **Users Table**
   - Contains employee details like `employee_id`, `password`, `name`, `birth_date`, `gender`, `email`, `contact_number`, `address`, `hire_date`, `is_active`, `salary`, `employee_type` - [manager, staff].
   - Manager details include: `manager_id` and `bonus_percentage`.
   - Staff details include: `staff_id` and `manager_id`.
   - Includes role-based `user_access_level` based off of `employee_type`.

2. **Inventory Table**
   - Tracks product details like `product_id`, `name`, `stock_quantity`, `price`, and `last_updated`.

3. **Transactions Table**
   - Records transaction details such as `transaction_id`, `user_id`, `product_id`, `quantity_sold`, `total_amount`, and `transaction_date`.

4. **Employee Attendance Table**
   - Logs attendance data such as `attendance_id`, `user_id`, `date`, `shift_start`, `shift_end`, and `shift_status`.

5. **User Access Levels Table**
   - Defines permissions for roles (e.g., Admin, Manager, Employee).

## Installation Instructions
1. **Clone the Repository**:
   ```bash
   git clone <repository-url>
