# 🩸 Blood Bank Management System - PHP Project

This is a web-based Blood Bank Management System built using PHP and MySQL. It allows users to manage blood donor records, search for available blood types, and view donor details.

---

## 🧰 Features

- Donor registration and availability status
- Blood type and location-based search
- Request donors
- Clean and user-friendly UI

---

## 📦 Project Structure

bloodbridge/
├── config.php
├── fetch_donors,php
├── index.php
├── login.php
├── logout.php
├── register.php
├── register_donor.php
└── bloodbridge_schema.sql ← Database file

---

## 🚀 How to Run This Project

Follow these steps to set up and run the Blood Bank project on your local machine:

### ✅ Requirements

- [XAMPP](https://www.apachefriends.org/index.html)
- PHP (included in XAMPP)
- MySQL (included in XAMPP)
- Web browser (e.g., Chrome)

---

### 🛠️ Setup Instructions

1. **Download & Install XAMPP**

   - Go to: https://www.apachefriends.org/index.html
   - Download and install the XAMPP version suitable for your system.

2. **Start Apache and MySQL**

   - Open **XAMPP Control Panel**
   - Click **Start** next to **Apache** and **MySQL**
   - Click **Admin** next to **MySQL** to open **phpMyAdmin**

3. **Import the Database**

   - In **phpMyAdmin**, create a new database named `bloodbridge`
   - Click **Import** tab
   - Select the file `bloodbridge_schema.sql` from the project folder
   - Click **Go** to import the database structure and sample data

4. **Place Project Files**

   - Copy the entire project folder `bloodbridge/` to:
     ```
     C:\xampp\htdocs\
     ```

5. **Run the Project**

   - Open a web browser
   - Visit:
     ```
     http://localhost/bloodbridge/index.php
     ```

---

## 🗂️ Database Info

- Database Name: `bloodbridge`
- Tables:
  - `request_donor`
  - `users`
  - `donors`
- Import file: `bloodbridge_schema.sql`

---

## 📌 Notes

- Make sure `config.php` has the correct database connection credentials:
  ```php
  $conn = new mysqli("localhost", "root", "", "bloodbridge");
