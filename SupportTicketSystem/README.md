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


## 🧪 Testing API Endpoints using POSTMAN (API)

### Base URL
```
http://localhost:8000/api
```

## 1. Authentication Endpoints

### 1.1 Register New User

**Request:**
- **Method:** `POST`
- **URL:** `{{base_url}}/api/register`
- **Headers:**
  - `Content-Type`: `application/json`
  - `Accept`: `application/json`
- **Body (raw JSON):**
```json
{
  "name": "Test User",
  "email": "testuser123456789@example.com",
  "password": "password123",
  "password_confirmation": "password123"
}
```

**Expected Response (201 Created):**
```json
{
  "success": true,
  "data": {
    "user": {
      "id": 6,
      "name": "Test User",
      "email": "testuser123456789@example.com",
      "created_at": "2025-01-12T10:30:00.000000Z",
      "updated_at": "2025-01-12T10:30:00.000000Z"
    },
    "token": "6|AbCdEfGhIjKlMnOpQrStUvWxYz123456789..." //might be different
  }
}
```

**💡 Tip:** Copy the `token` value for use in protected endpoints. (as some of the endpoints Authorization is required)

---

### 1.2 Login to Registered Account

**Request:**
- **Method:** `POST`
- **URL:** `{{base_url}}/api/login`
- **Headers:**
  - `Content-Type`: `application/json`
  - `Accept`: `application/json`
- **Body (raw JSON):**
```json
{
  "email": "jane.smith@example.com",
  "password": "password123"
}
```

**Expected Response (200 OK):**
```json
{
  "success": true,
  "data": {
    "user": {
      "id": 1,
      "name": "Jame Smith",
      "email": "jane.smith@example.com",
      "created_at": "2025-01-12T08:00:00.000000Z",
      "updated_at": "2025-01-12T08:00:00.000000Z"
    },
    "token": "1|XyZaBcDeFgHiJkLmNoPqRsTuVwXyZ123456789..."
  }
}
```

**📌 Important:** Save this token! You'll need it for all protected endpoints.

---

### 1.3 Get Current User Info

**Request:**
- **Method:** `GET`
- **URL:** `{{base_url}}/api/user`
- **Headers:**
  - `Authorization`: `Bearer {{token}}`
  - `Accept`: `application/json`

**Expected Response (200 OK):**
```json
{
  "success": true,
  "data": {
    "id": 1,
    "name": "Jane Smith",
    "email": "jane.smith@example.com",
    "created_at": "2025-01-12T08:00:00.000000Z",
    "updated_at": "2025-01-12T08:00:00.000000Z"
  }
}
```

---

### 1.4 Logout

**Request:**
- **Method:** `POST`
- **URL:** `{{base_url}}/api/logout`
- **Headers:**
  - `Authorization`: `Bearer {{token}}`
  - `Accept`: `application/json`

**Expected Response (200 OK):**
```json
{
  "success": true,
  "message": "Logged out successfully"
}
```

---

## 2. Ticket Endpoints (Protected)

**⚠️ All ticket endpoints require authentication!**  
Add this header to all requests below:
- `Authorization`: `Bearer {{token}}`

---

### 2.1 Get My Tickets

Retrieve all tickets created by the authenticated user.

**Request:**
- **Method:** `GET`
- **URL:** `{{base_url}}/api/tickets`
- **Headers:**
  - `Authorization`: `Bearer {{token}}`
  - `Accept`: `application/json`

**Query Parameters (Optional):**
- `status` - Filter by status (open, in_progress, resolved, closed)
- `priority` - Filter by priority (low, medium, high)
- `search` - Search by title

**Example with Filters:**
```
{{base_url}}/api/tickets?status=open&priority=high
```

**Expected Response (200 OK):**
```json
{
  "success": true,
  "data": {
    "current_page": 1,
    "data": [
      {
        "id": 1,
        "title": "Login Issue",
        "description": "Cannot login with correct credentials",
        "status": "open",
        "priority": "high",
        "created_by": 1,
        "created_at": "2025-01-12T10:30:00.000000Z",
        "updated_at": "2025-01-12T10:30:00.000000Z",
        "deleted_at": null,
        "creator": {
          "id": 1,
          "name": "Pei Pei Wee",
          "email": "peipei.wee@bitzaro.com"
        },
        "comments": []
      }
    ],
    "first_page_url": "http://localhost:8000/api/tickets?page=1",
    "from": 1,
    "last_page": 1,
    "per_page": 10,
    "to": 1,
    "total": 1
  }
}
```

---

### 2.2 Get All Tickets

Retrieve all tickets in the system (for browsing and commenting).

**Request:**
- **Method:** `GET`
- **URL:** `{{base_url}}/api/tickets/all`
- **Headers:**
  - `Authorization`: `Bearer {{token}}`
  - `Accept`: `application/json`

**Query Parameters (Optional):**
Same as "Get My Tickets"

**Expected Response (200 OK):**
Similar to "Get My Tickets" but includes tickets from all users.

---

### 2.3 Get Single Ticket Details

**Request:**
- **Method:** `GET`
- **URL:** `{{base_url}}/api/tickets/1` //check the id of tickets if it is in the database
- **Headers:**
  - `Authorization`: `Bearer {{token}}`
  - `Accept`: `application/json`

**Expected Response (200 OK):**
```json
{
  "success": true,
  "data": {
    "id": 1,
    "title": "Login Issue",
    "description": "Cannot login with correct credentials",
    "status": "open",
    "priority": "high",
    "created_by": 1,
    "created_at": "2025-01-12T10:30:00.000000Z",
    "updated_at": "2025-01-12T10:30:00.000000Z",
    "deleted_at": null,
    "creator": {
      "id": 1,
      "name": "Pei Pei Wee",
      "email": "peipei.wee@bitzaro.com"
    },
    "comments": [
      {
        "id": 1,
        "ticket_id": 1,
        "user_id": 2,
        "message": "I'm investigating this issue",
        "created_at": "2025-01-12T11:00:00.000000Z",
        "updated_at": "2025-01-12T11:00:00.000000Z",
        "user": {
          "id": 2,
          "name": "John Doe",
          "email": "john.doe@example.com"
        }
      }
    ]
  }
}
```

---

### 2.4 Create New Ticket

**Request:**
- **Method:** `POST`
- **URL:** `{{base_url}}/api/tickets`
- **Headers:**
  - `Authorization`: `Bearer {{token}}`
  - `Content-Type`: `application/json`
  - `Accept`: `application/json`
- **Body (raw JSON):**
```json
{
  "title": "Dashboard not loading",
  "description": "The dashboard page takes too long to load and sometimes shows a timeout error",
  "priority": "high"
}
```

**Field Details:**
- `title` - **Required**, string, max 255 characters
- `description` - **Required**, string (text)
- `priority` - **Optional**, values: `low`, `medium`, `high` (default: `medium`)
- `status` - Auto-set to `open` (cannot be specified on creation)

**Expected Response (201 Created):**
```json
{
  "success": true,
  "data": {
    "id": 13,
    "title": "Dashboard not loading",
    "description": "The dashboard page takes too long to load and sometimes shows a timeout error",
    "status": "open",
    "priority": "high",
    "created_by": 1,
    "created_at": "2025-01-12T14:30:00.000000Z",
    "updated_at": "2025-01-12T14:30:00.000000Z",
    "deleted_at": null,
    "creator": {
      "id": 1,
      "name": "Jane Smith",
      "email": "jane.smith@example.com"
    },
    "comments": []
  },
  "message": "Ticket created successfully"
}
```

---

### 2.5 Update Ticket

**⚠️ Only ticket owner can update their own tickets!**

**Request:**
- **Method:** `PUT`
- **URL:** `{{base_url}}/api/tickets/13`
- **Headers:**
  - `Authorization`: `Bearer {{token}}`
  - `Content-Type`: `application/json`
  - `Accept`: `application/json`
- **Body (raw JSON):**
```json
{
  "title": "Dashboard loading issue - RESOLVED",
  "description": "Updated: Fixed by clearing cache",
  "priority": "medium",
  "status": "resolved"
}
```

**Field Details:**
- All fields are **optional** (update only what you need)
- `status` - Can only be updated to: `in_progress`, `resolved`, `closed` (NOT `open`)
- Only the ticket owner can update

**Expected Response (200 OK):**
```json
{
  "success": true,
  "data": {
    "id": 13,
    "title": "Dashboard loading issue - RESOLVED",
    "description": "Updated: Fixed by clearing cache",
    "status": "resolved",
    "priority": "medium",
    "created_by": 1,
    "created_at": "2025-01-12T14:30:00.000000Z",
    "updated_at": "2025-01-12T15:00:00.000000Z",
    "deleted_at": null,
    "creator": {
      "id": 1,
      "name": "Pei Pei Wee"
    },
    "comments": []
  },
  "message": "Ticket updated successfully"
}
```

**Error Response - Unauthorized (403):**
```json
{
  "success": false,
  "message": "You are not authorized to update this ticket."
}
```

---

### 2.6 Delete Ticket

**⚠️ Only ticket owner can delete their own tickets! (Soft Delete)**

**Request:**
- **Method:** `DELETE`
- **URL:** `{{base_url}}/api/tickets/13`
- **Headers:**
  - `Authorization`: `Bearer {{token}}`
  - `Accept`: `application/json`

**Expected Response (200 OK):**
```json
{
  "success": true,
  "message": "Ticket deleted successfully"
}
```

**Error Response - Unauthorized (403):**
```json
{
  "success": false,
  "message": "You are not authorized to delete this ticket."
}
```

---

## 3. Comment Endpoints (Protected)

**💡 Any authenticated user can comment on any ticket!**

---

### 3.1 Add Comment to Ticket

**Request:**
- **Method:** `POST`
- **URL:** `{{base_url}}/api/tickets/1/comments`
- **Headers:**
  - `Authorization`: `Bearer {{token}}`
  - `Content-Type`: `application/json`
  - `Accept`: `application/json`
- **Body (raw JSON):**
```json
{
  "message": "I found a solution! Try clearing your browser cache and cookies."
}
```

**Field Details:**
- `message` - **Required**, string (text)

**Expected Response (201 Created):**
```json
{
  "success": true,
  "data": {
    "id": 8,
    "ticket_id": 1,
    "user_id": 1,
    "message": "I found a solution! Try clearing your browser cache and cookies.",
    "created_at": "2025-01-12T15:30:00.000000Z",
    "updated_at": "2025-01-12T15:30:00.000000Z",
    "user": {
      "id": 1,
      "name": "Pei Pei Wee",
      "email": "peipei.wee@bitzaro.com"
    }
  }
}
```

---

## 4. Error Responses

### 4.1 Validation Error (422)

**Example Request:** Create ticket without required fields
```json
{
  "description": "Missing title"
}
```

**Response:**
```json
{
  "success": false,
  "message": "Validation error",
  "errors": {
    "title": [
      "The title field is required."
    ]
  }
}
```

---

### 4.2 Unauthenticated (401)

**Cause:** Missing or invalid token

**Response:**
```json
{
  "success": false,
  "message": "Unauthenticated"
}
```

---

### 4.3 Forbidden (403)

**Cause:** Trying to update/delete someone else's ticket

**Response:**
```json
{
  "success": false,
  "message": "You are not authorized to update this ticket."
}
```

---

### 4.4 Not Found (404)

**Cause:** Ticket doesn't exist

**Response:**
```json
{
  "success": false,
  "message": "Resource not found"
}
```









