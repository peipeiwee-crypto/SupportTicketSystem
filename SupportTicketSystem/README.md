# Support Ticket System

A comprehensive web-based support ticket management system built with Laravel 10, MySQL, and Laravel Sanctum for API authentication. This system allows users to create, manage, and track support tickets with real-time comments and filtering capabilities.

## 📋 Table of Contents

- [Features](#features)
- [Tech Stack](#tech-stack)
- [Requirements](#requirements)
- [Installation](#installation)
- [Database Setup](#database-setup)
- [Configuration](#configuration)
- [Running the Application](#running-the-application)
- [API Endpoints](#api-endpoints)

## ✨ Features

### User Authentication
- ✅ User registration with validation
- ✅ Secure login/logout with Laravel Sanctum
- ✅ Token-based API authentication

### Ticket Management
- ✅ Create new support tickets
- ✅ View paginated list of own tickets (10 per page)
- ✅ View all tickets in the system
- ✅ Update ticket details (title, description, priority, status)
- ✅ Soft delete tickets
- ✅ Filter tickets by status and priority
- ✅ Search tickets by title

### Comments System
- ✅ Add comments to any ticket
- ✅ View all comments on a ticket
- ✅ Comments ordered by creation time
- ✅ Real-time comment count updates

### Security & Permissions
- ✅ Only ticket owners can edit/delete their tickets
- ✅ All authenticated users can view and comment on any ticket
- ✅ Status can only be updated to: `in_progress`, `resolved`, `closed` (not back to `open`)
- ✅ Form Request validation for all inputs
- ✅ Proper HTTP status codes (200, 201, 401, 403, 422, 500)

## 🛠 Tech Stack

- **Backend Framework:** Laravel 10
- **PHP Version:** 8.2.12
- **Database:** MySQL / MariaDB
- **Authentication:** Laravel Sanctum
- **Package Manager:** Composer 2.9.2
- **Frontend:** Blade Templates, Vanilla JavaScript, CSS3
- **API:** RESTful JSON API

## 📦 Requirements

- PHP >= 8.2.12
- Composer >= 2.9.2
- MySQL >= 5.7 or MariaDB >= 10.3
- Node.js & NPM (optional, for asset compilation)

## 🚀 Installation

### 1. Clone the Repository

```bash
git clone https://github.com/yourusername/support-ticket-system.git
cd support-ticket-system
```

### 2. Install Dependencies

```bash
composer install
```

### 3. Environment Configuration

Copy the `.env.example` file to `.env`:

```bash
cp .env.example .env
```

Generate application key:

```bash
php artisan key:generate
```

### 4. Configure Database

Edit the `.env` file with your database credentials:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=support_ticket_system
DB_USERNAME=root
DB_PASSWORD=your_password_here
```

## 💾 Database Setup

### Option 1: Using Migrations (Recommended)

```bash
php artisan migrate
```

### Option 2: Using Raw SQL

If you prefer to create tables manually, run the SQL file:

```bash
mysql -u root -p support_ticket_system < database/sql/create_tables.sql
```

Then mark migrations as complete:

```sql
USE support_ticket_system;

INSERT INTO migrations (migration, batch) VALUES
('2024_12_01_000001_create_tickets_table', 1),
('2024_12_01_000002_create_ticket_comments_table', 1);
```

## 📊 Database Schema

### Tables

#### `users`
| Column | Type | Description |
|--------|------|-------------|
| id | BIGINT UNSIGNED PK | User ID |
| name | VARCHAR(255) | User's full name |
| email | VARCHAR(255) UNIQUE | User's email address |
| password | VARCHAR(255) | Hashed password |
| created_at | TIMESTAMP | Account creation time |
| updated_at | TIMESTAMP | Last update time |

#### `tickets`
| Column | Type | Description |
|--------|------|-------------|
| id | BIGINT UNSIGNED PK | Ticket ID |
| title | VARCHAR(255) | Ticket title |
| description | TEXT | Ticket description |
| status | ENUM | `open`, `in_progress`, `resolved`, `closed` |
| priority | ENUM | `low`, `medium`, `high` |
| created_by | BIGINT UNSIGNED FK | References `users.id` |
| created_at | TIMESTAMP | Creation time |
| updated_at | TIMESTAMP | Last update time |
| deleted_at | TIMESTAMP | Soft delete timestamp |

#### `ticket_comments`
| Column | Type | Description |
|--------|------|-------------|
| id | BIGINT UNSIGNED PK | Comment ID |
| ticket_id | BIGINT UNSIGNED FK | References `tickets.id` |
| user_id | BIGINT UNSIGNED FK | References `users.id` |
| message | TEXT | Comment content |
| created_at | TIMESTAMP | Creation time |
| updated_at | TIMESTAMP | Last update time |

### Relationships

- `User` → `hasMany(Ticket)` - A user creates many tickets
- `Ticket` → `belongsTo(User, 'created_by')` - A ticket belongs to a user
- `Ticket` → `hasMany(TicketComment)` - A ticket has many comments
- `TicketComment` → `belongsTo(Ticket)` - A comment belongs to a ticket
- `TicketComment` → `belongsTo(User)` - A comment belongs to a user

**Data Integrity:** All relationships use `ON DELETE CASCADE`

## ⚙️ Configuration

### Laravel Sanctum Setup

Publish Sanctum configuration:

```bash
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
php artisan config:clear
```

## 🏃 Running the Application

### Start the Development Server

```bash
php artisan serve
```

The application will be available at: `http://localhost:8000`

### Optional: Seed Sample Data

Create a seeder for test users:

```bash
php artisan make:seeder UserSeeder
php artisan db:seed --class=UserSeeder
```

## 🔌 API Endpoints

### Base URL
```
http://localhost:8000/api
```

### Authentication Endpoints

#### Register
```http
POST /api/register
Content-Type: application/json

{
  "name": "John Doe",
  "email": "john@example.com",
  "password": "password123",
  "password_confirmation": "password123"
}
```

**Response (201):**
```json
{
  "success": true,
  "data": {
    "user": {
      "id": 1,
      "name": "John Doe",
      "email": "john@example.com"
    },
    "token": "1|abc123..."
  }
}
```

#### Login
```http
POST /api/login
Content-Type: application/json

{
  "email": "john@example.com",
  "password": "password123"
}
```

**Response (200):**
```json
{
  "success": true,
  "data": {
    "user": { ... },
    "token": "2|xyz789..."
  }
}
```

#### Logout
```http
POST /api/logout
Authorization: Bearer {token}
```

**Response (200):**
```json
{
  "success": true,
  "message": "Logged out successfully"
}
```

### Ticket Endpoints (Protected)

All ticket endpoints require authentication header:
```
Authorization: Bearer {your_token}
```

#### Get My Tickets
```http
GET /api/tickets?status=open&priority=high&search=bug
```

**Response (200):**
```json
{
  "success": true,
  "data": {
    "current_page": 1,
    "data": [
      {
        "id": 1,
        "title": "Bug in login",
        "description": "Cannot login with correct credentials",
        "status": "open",
        "priority": "high",
        "created_by": 1,
        "created_at": "2025-01-12T10:30:00.000000Z",
        "comments": []
      }
    ],
    "per_page": 10,
    "total": 1
  }
}
```

#### Get All Tickets
```http
GET /api/tickets/all?status=open&priority=high
```

#### Get Ticket Details
```http
GET /api/tickets/{id}
```

**Response (200):**
```json
{
  "success": true,
  "data": {
    "id": 1,
    "title": "Bug in login",
    "description": "Cannot login with correct credentials",
    "status": "open",
    "priority": "high",
    "created_by": 1,
    "creator": {
      "id": 1,
      "name": "John Doe",
      "email": "john@example.com"
    },
    "comments": [
      {
        "id": 1,
        "message": "Looking into this issue",
        "user": {
          "id": 2,
          "name": "Jane Smith"
        },
        "created_at": "2025-01-12T11:00:00.000000Z"
      }
    ]
  }
}
```

#### Create Ticket
```http
POST /api/tickets
Content-Type: application/json

{
  "title": "Bug in login",
  "description": "Cannot login with correct credentials",
  "priority": "high"
}
```

**Response (201):**
```json
{
  "success": true,
  "data": { ... },
  "message": "Ticket created successfully"
}
```

#### Update Ticket
```http
PUT /api/tickets/{id}
Content-Type: application/json

{
  "title": "Updated title",
  "description": "Updated description",
  "priority": "medium",
  "status": "in_progress"
}
```

**Response (200):**
```json
{
  "success": true,
  "data": { ... },
  "message": "Ticket updated successfully"
}
```

**Note:** Status can only be updated to `in_progress`, `resolved`, or `closed` (not `open`)

#### Delete Ticket
```http
DELETE /api/tickets/{id}
```

**Response (200):**
```json
{
  "success": true,
  "message": "Ticket deleted successfully"
}
```

### Comment Endpoints (Protected)

#### Add Comment to Ticket
```http
POST /api/tickets/{id}/comments
Content-Type: application/json

{
  "message": "This is my comment on the ticket"
}
```

**Response (201):**
```json
{
  "success": true,
  "data": {
    "id": 1,
    "ticket_id": 1,
    "user_id": 2,
    "message": "This is my comment on the ticket",
    "user": {
      "id": 2,
      "name": "Jane Smith"
    },
    "created_at": "2025-01-12T11:00:00.000000Z"
  }
}
```

### Error Responses

#### Validation Error (422)
```json
{
  "success": false,
  "message": "Validation error",
  "errors": {
    "title": ["The title field is required."],
    "email": ["The email has already been taken."]
  }
}
```

#### Unauthorized (401)
```json
{
  "success": false,
  "message": "Unauthenticated"
}
```

#### Forbidden (403)
```json
{
  "success": false,
  "message": "You are not authorized to update this ticket."
}
```

#### Not Found (404)
```json
{
  "success": false,
  "message": "Resource not found"
}
```

## 🧪 Testing

You can test the API using tools like:
- **Postman**: Import the API collection
- **cURL**: Use command-line requests
- **Browser**: Visit `http://localhost:8000` for the web interface

### Example cURL Commands

**Register:**
```bash
curl -X POST http://localhost:8000/api/register \
  -H "Content-Type: application/json" \
  -d '{"name":"John Doe","email":"john@example.com","password":"password123","password_confirmation":"password123"}'
```

**Login:**
```bash
curl -X POST http://localhost:8000/api/login \
  -H "Content-Type: application/json" \
  -d '{"email":"john@example.com","password":"password123"}'
```

**Get Tickets:**
```bash
curl -X GET http://localhost:8000/api/tickets \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -H "Accept: application/json"
```

## 📁 Project Structure

```
support-ticket-system/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   └── Api/
│   │   │       ├── AuthController.php
│   │   │       ├── TicketController.php
│   │   │       └── TicketCommentController.php
│   │   └── Requests/
│   │       ├── StoreTicketRequest.php
│   │       ├── UpdateTicketRequest.php
│   │       └── StoreCommentRequest.php
│   └── Models/
│       ├── User.php
│       ├── Ticket.php
│       └── TicketComment.php
├── database/
│   ├── migrations/
│   └── sql/
│       └── create_tables.sql
├── public/
│   ├── css/
│   │   └── app.css
│   └── js/
│       └── app.js
├── resources/
│   └── views/
│       ├── layouts/
│       │   └── app.blade.php
│       ├── partials/
│       │   ├── header.blade.php
│       │   └── modals.blade.php
│       └── home.blade.php
├── routes/
│   ├── api.php
│   └── web.php
├── .env.example
├── composer.json
└── README.md
```

## 📸 Screenshots

### Login Page
Users can securely log in to access the ticket system.

### Registration Page
New users can create an account with validation.

### My Tickets
View and manage tickets created by the logged-in user with filters and search.

### All Tickets
Browse all tickets in the system and add comments to any ticket.

### Ticket Details
View complete ticket information with all comments and add new comments.

## 🔒 Security Features

- ✅ Password hashing with bcrypt
- ✅ CSRF protection
- ✅ SQL injection prevention (Eloquent ORM)
- ✅ XSS protection (Blade escaping)
- ✅ Token-based API authentication
- ✅ Authorization checks for edit/delete operations
- ✅ Input validation with Form Requests

## 🐛 Troubleshooting

### Common Issues

**Issue:** `Could not open input file: artisan`
- **Solution:** Make sure you're in the project root directory

**Issue:** Database connection error
- **Solution:** Check your `.env` database credentials and ensure MySQL is running

**Issue:** `Class 'App\Models\Ticket' not found`
- **Solution:** Run `composer dump-autoload`

**Issue:** Token authentication not working
- **Solution:** Make sure Sanctum is published: `php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"`

## 📝 Sample User Credentials

After seeding (if implemented):
- **Email:** admin@example.com
- **Password:** password123

## 🤝 Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## 📄 License

This project is open-source and available under the [MIT License](LICENSE).

## 👨‍💻 Author

**Your Name**
- GitHub: [@yourusername](https://github.com/yourusername)
- Email: your.email@example.com

## 🙏 Acknowledgments

- Laravel Framework
- Laravel Sanctum
- MySQL Database
- Bootstrap (if used)

---

**Built with ❤️ using Laravel 10**