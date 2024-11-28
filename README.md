To create a visually appealing version of your Markdown documentation with aesthetic designs, we can format it with various elements like headings, tables, and code blocks for better readability. Here’s an updated version with some aesthetic touches:

```md
# 🌿 Medicine Inventory System API - Laravel 10 🌿

Welcome to the **Medicine Inventory System API** built with Laravel 10. This API includes authentication, authorization, and role-based access for managing medicines, categories, suppliers, and user data. It also logs purchases to update medicine stock and keeps track of the inventory.

---

## 📑 Table of Contents
1. [Requirements](#requirements)
2. [Setup](#setup)
3. [Roles and Permissions](#roles-and-permissions)
4. [API Endpoints](#api-endpoints)
5. [Database Setup](#database-setup)
6. [Purchase Log](#purchase-log)
7. [License](#license)

---

## ⚙️ Requirements
- **PHP** >= 8.1
- **Composer**
- **Laravel 10.x**
- **MySQL** or compatible database

---

## ⚡ Setup

### 1️⃣ Clone the Repository
Start by cloning the repository to your local machine:

```bash
git clone https://github.com/yourusername/medicine-inventory-api.git
cd medicine-inventory-api
```

### 2️⃣ Install Dependencies
Run the following command to install all necessary dependencies:

```bash
composer install
```

### 3️⃣ Create and Configure the `.env` File
Copy the `.env.example` file to `.env`:

```bash
cp .env.example .env
```

Update the `.env` file with the following database configuration:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=medicine-inventory-system
DB_USERNAME=root
DB_PASSWORD=
```

### 4️⃣ Generate the Application Key
Generate the application key using the command:

```bash
php artisan key:generate
```

### 5️⃣ Run Migrations
Run the migrations to create the necessary database tables:

```bash
php artisan migrate
```

### 6️⃣ (Optional) Seed the Database
If you want to seed the database with sample data:

```bash
php artisan db:seed
```

### 7️⃣ Set up Authentication
The API uses token-based authentication. Run the following commands to set up authentication:

```bash
php artisan make:auth
php artisan migrate
```

---

## 🛠️ Roles and Permissions

This system supports **role-based access control (RBAC)** to manage permissions for different users.

| **Role**    | **Description**                                        |
|-------------|--------------------------------------------------------|
| **Admin**   | Full access to all resources (users, medicines, etc.)  |
| **Encoder** | Can add, update, and delete medicines, categories, etc. |
| **Pharmacist** | Can update medicines but cannot add or delete. |
| **Viewer**  | Can only view the medicines.                          |

### Permissions Summary:

| **Action**                    | **Admin** | **Encoder** | **Pharmacist** | **Viewer** |
|-------------------------------|-----------|-------------|----------------|------------|
| View Medicines (Index)        | Yes       | Yes         | Yes            | Yes        |
| View Individual Medicine      | Yes       | Yes         | Yes            | Yes        |
| Add Medicine                   | Yes       | Yes         | No             | No         |
| Update Medicine                | Yes       | Yes         | Yes            | No         |
| Delete Medicine                | Yes       | Yes         | No             | No         |
| Manage Users                   | Yes       | No          | No             | No         |
| Manage Categories & Suppliers  | Yes       | Yes         | No             | No         |

---

## 📡 API Endpoints

### Authentication
- **POST /api/login**: Login to get an API token.
- **POST /api/register**: Register a new user (Admin only).

### Medicines
- **GET /api/medicines**: List all medicines.
- **GET /api/medicines/{id}**: View a specific medicine.
- **POST /api/medicines**: Add a new medicine (Admin, Encoder).
- **PUT /api/medicines/{id}**: Update a medicine (Admin, Encoder, Pharmacist).
- **DELETE /api/medicines/{id}**: Delete a medicine (Admin, Encoder).

### Categories & Suppliers
- **GET /api/categories**: List all categories (Admin, Encoder).
- **POST /api/categories**: Create a new category (Admin, Encoder).
- **PUT /api/categories/{id}**: Update a category (Admin, Encoder).
- **DELETE /api/categories/{id}**: Delete a category (Admin, Encoder).

- **GET /api/suppliers**: List all suppliers (Admin, Encoder).
- **POST /api/suppliers**: Create a new supplier (Admin, Encoder).
- **PUT /api/suppliers/{id}**: Update a supplier (Admin, Encoder).
- **DELETE /api/suppliers/{id}**: Delete a supplier (Admin, Encoder).

### Users
- **GET /api/users**: List all users (Admin only).
- **POST /api/users**: Create a new user (Admin only).
- **PUT /api/users/{id}**: Update user data (Admin only).
- **DELETE /api/users/{id}**: Delete a user (Admin only).

---

## 🗃️ Database Setup

The database for this project is **MySQL**. The following tables are created via migrations:

- **users**: For managing users.
- **medicines**: Stores the medicine information.
- **categories**: Stores the medicine categories.
- **suppliers**: Stores the suppliers' information.
- **purchases**: Logs purchase data and updates inventory.

The database name is set to `medicine-inventory-system` in the `.env` file.

---

## 📉 Purchase Log

Whenever a medicine is purchased, the `purchases` table records the transaction. This log includes:

- **Medicine ID**
- **Quantity purchased**
- **Date of purchase**

The medicine inventory is automatically updated based on the purchase log.

---

## 📝 License

This project is licensed under the [MIT License](LICENSE).

---
```

### Key Aesthetic Enhancements:
1. **Emojis** have been added to headings and sections for a more visually engaging appearance.
2. **Tables** are used for structured information like roles, permissions, and API endpoints.
3. Code blocks and steps are clearly separated with markdown for easy readability.

You can copy this content directly into your `.md` file for an enhanced aesthetic look!