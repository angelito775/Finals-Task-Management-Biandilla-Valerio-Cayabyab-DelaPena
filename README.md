
## Requirements

- PHP 8.2+
- Composer
- MySQL 8.0+
- Node.js 18+

## Setup Instructions

1. **Clone the repository:**

```bash
git clone <repository-url>
cd Finals-Task-Management
```

2. **Install PHP dependencies:**

```bash
composer install
```

3. **Install frontend dependencies:**

```bash
npm install
npm run build
```

4. **Configure the environment:**

```bash
cp .env.example .env
php artisan key:generate
```

**NOTE**
In this project especially in .env we dont use SESSION_DRIVER=database. We use SESSION_DRIVER=file. We did not include session table/migration or any login logics because it is not included in the rubric so it only does is do CRUD and store it the database.

5. **Create the database and import:**

Create a MySQL database named `finals`, then import the provided dump:

```bash
mysql -u root -e "CREATE DATABASE finals;"
```

Alternatively, you can run migrations and seeders instead of importing the SQL dump:

```bash
php artisan migrate --seed
```

6. **Start the development server:**

```bash
php artisan serve
```

The application will be available at `http://localhost:8000`.

## Database
1.  **Database Architecture & Table Relationships**
The application is built on a strictly normalized relational database schema. The tasks table acts as the central hub and maintains One-to-Many relationships with three distinct lookup tables:

Categories: Linked via category_id. Allows tasks to be grouped (e.g., Work, Personal) and inherit specific UI colors.

Priorities: Linked via priority_id (defaults to ID 2). Defines the urgency level of the task.

Statuses: Linked via status_id (defaults to ID 1). Tracks the current lifecycle state of the task (e.g., Pending, Completed).

Database-Level Implementation:

All three foreign keys on the tasks table (category_id, priority_id, status_id) explicitly reference the primary id columns of their respective parent tables.

A strict cascadeOnDelete constraint is applied to all three relationships at the migration level. If a category, priority, or status is removed from the system, all associated tasks are automatically purged. This guarantees referential integrity and prevents application crashes caused by orphaned data.

Application-Level Implementation (Eloquent ORM):

Inside the Laravel backend, these SQL structures are mapped using Eloquent ORM. The Task model utilizes belongsTo methods for each relationship, while the lookup models utilize hasMany methods.

