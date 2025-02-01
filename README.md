# Event Management System

A **PHP/MySQL-based Event Management System** for creating, managing, and tracking events.

---

## Features
- **User Authentication**: Secure login and registration with password hashing.
- **Event Management**: Create, update, view, and delete events.
- **Attendee Management**: Register attendees for events with capacity checks.
- **Reports**: Download attendee lists as CSV files (admin-only).
- **Responsive Design**: Works on both desktop and mobile devices.

---

## Setup Instructions

### 1. Prerequisites
- **PHP 7.4+** (or higher).
- **MySQL Database**.
- **Web Server** (e.g., Apache, Nginx).
- **Composer** (optional, for autoloading).

### 2. Database Setup
1. Create a database named `event_system`.
2. Import the SQL schema:
   ```sql
   CREATE TABLE users (
     id INT AUTO_INCREMENT PRIMARY KEY,
     email VARCHAR(255) UNIQUE NOT NULL,
     password VARCHAR(255) NOT NULL,
     is_admin BOOLEAN DEFAULT 0,
     created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
   );

   CREATE TABLE events (
     id INT AUTO_INCREMENT PRIMARY KEY,
     user_id INT,
     title VARCHAR(255) NOT NULL,
     description TEXT,
     date DATETIME NOT NULL,
     location VARCHAR(255),
     max_capacity INT,
     created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
     FOREIGN KEY (user_id) REFERENCES users(id)
   );

   CREATE TABLE attendees (
     id INT AUTO_INCREMENT PRIMARY KEY,
     event_id INT,
     name VARCHAR(255) NOT NULL,
     email VARCHAR(255) NOT NULL,
     registered_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
     FOREIGN KEY (event_id) REFERENCES events(id)
   );