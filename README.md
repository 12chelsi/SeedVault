# LiveSlate Backend

This is the backend API project for the **LiveSlate** School Management System built with Laravel.

## 🛠️ System Requirements

Make sure you have the following installed:

-   PHP >= 8.1
-   Composer
-   Node.js & npm
-   MySQL or any other configured database
-   Laravel CLI (`laravel` command)

---

## 🚀 Project Setup

### 1. Clone the Repository

```bash
git clone https://github.com/axixatechnologies/LiveSlate-Backend.git
cd LiveSlate-Backend
```

---

### 2. Install PHP Dependencies

```bash
composer update
```

---

### 3. Install Node Modules

```bash
npm install
```

---

### 4. Copy `.env` File

```bash
cp .env.example .env
```

---

### 5. Generate App Key

```bash
php artisan key:generate
```

---

### 6. Configure Database

Open the `.env` file and update the following lines with your local database credentials:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password
```

---

### 7. Run Migrations

```bash
php artisan migrate
```

---

### 8. Build Frontend Assets

```bash
npm run dev
```

---

### 9. Serve the Application

```bash
php artisan serve
```

---

### ✅ Done!

Open your browser and visit:
[http://127.0.0.1:8000](http://127.0.0.1:8000)

Your Laravel backend project is now up and running 🎉

---

## 📁 Folder Structure

This project follows Laravel's default MVC architecture and folder structure.

---
