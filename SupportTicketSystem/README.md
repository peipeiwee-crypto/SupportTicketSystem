# Support Ticket System

A web-based support ticket management system built with Laravel 10, MySQL, and Laravel Sanctum for API authentication.

## 📋 Requirements

- PHP >= 8.2.12
- Composer >= 2.9.2
- MySQL >= 5.7 or MariaDB >= 10.3

## 🚀 Setup Instructions

### 1. Clone the Repository

```bash
git clone https://github.com/peipeiwee-crypto/SupportTicketSystem.git
cd support-ticket-system
```

### 2. Install Dependencies

```bash
composer install
```

### 3. Configure Database

Edit `.env` file with your database credentials:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=support_ticket_system
DB_USERNAME=root
DB_PASSWORD=your_password_here
```

### 4. Database Setup

**Option A: Import SQL File (Recommended - Includes Sample Data)**

```bash
# Create database
mysql -u root -p -e "CREATE DATABASE support_ticket_system;"

# Import the SQL file
mysql -u root -p support_ticket_system < database/support_ticket_system.sql
```

**Option B: Run Migrations+Seeder**

```bash
php artisan migrate
php artisan db:seed
```

### 5. Start Development Server

```bash
php artisan serve
```

Visit: `http://localhost:8000`

## 👤 Sample User Credentials

If you imported the SQL file with sample data, use these credentials:

**Email:** `xinen.lim@bitzaro.com`  
**Password:** `limxinen`


## 🧪 Testing API Endpoints

### Base URL
```
http://localhost:8000/api
```

### 1. Authentication Endpoints

#### Register New User
```bash
Invoke-WebRequest -Uri "http://127.0.0.1:8000/api/register" `
  -Method POST `
  -Headers @{ "Content-Type" = "application/json" } `
  -Body '{
    "name": "Test User",
    "email": "test@example.com",
    "password": "password123",
    "password_confirmation": "password123"
  }'
```

**Expected Response (201):**
```json
{
  "success": true,
  "data": {
    "user": {
      "id": 2,
      "name": "Test User",
      "email": "test@example.com"
    },
    "token": "1|AbCdEfGhIjKlMnOpQrStUvWxYz..."
  }
}
```

#### Login
```bash
Invoke-WebRequest -Uri "http://127.0.0.1:8000/api/login" `
  -Method POST `
  -Headers @{ "Content-Type" = "application/json" } `
  -Body '{
    "email": "xinen.lim@bitzaro.com",
    "password": "limxinen"
  }'
```

**Expected Response (200):**
```json
{
  "success": true,
  "data": {
    "user": {
      "id": 1,
      "name": "Xin En",
      "email": "xinen.lim@bitzaro.com"
    },
    "token": "2|XyZaBcDeFgHiJkLmNoPqRsTuVw..."
  }
}
```

## 🌐 Testing via Web Interface

1. Visit `http://localhost:8000`
2. Login with sample credentials:
   - **Email:** `xinen.lim@bitzaro.com`
   - **Password:** `limxinen`
3. Features available:
   - **My Tickets Tab:** View and manage your tickets
   - **All Tickets Tab:** Browse all tickets in the system
   - **Create Ticket:** Click "Create New Ticket" button
   - **View Details:** Click on any ticket card
   - **Add Comments:** Open ticket details and scroll to comments section
   - **Edit/Delete:** Only available on your own tickets

---







