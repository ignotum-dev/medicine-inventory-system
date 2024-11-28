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
git clone https://github.com/ignotum-dev/medicine-inventory-system
cd medicine-inventory-system
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

## 🔧 System Routes

| Method        | URI                                         | Action                                                        | Controller                               |
|---------------|---------------------------------------------|--------------------------------------------------------------|------------------------------------------|
| **GET|HEAD**   | `/`                                         | Displays the home page or root response.                      | `\App\Http\Controllers\HomeController@index`  |
| **POST**      | `/_ignition/execute-solution`              | Executes a solution for Laravel Ignition errors.              | `Spatie\LaravelIgnition\SolutionController@executeSolution` |
| **GET|HEAD**  | `/_ignition/health-check`                  | Health check endpoint for Laravel Ignition.                   | `Spatie\LaravelIgnition\HealthCheckController@healthCheck` |
| **POST**      | `/_ignition/update-config`                 | Updates the Laravel Ignition configuration.                   | `Spatie\LaravelIgnition\UpdateConfigController@updateConfig` |

---

## 🏷️ Categories Routes

| Method        | URI                                         | Action                                                        | Controller                               |
|---------------|---------------------------------------------|--------------------------------------------------------------|------------------------------------------|
| **GET|HEAD**  | `/api/categories`                          | Lists all categories.                                         | `CategoryController@index`               |
| **POST**      | `/api/categories`                          | Creates a new category.                                       | `CategoryController@store`               |
| **GET|HEAD**  | `/api/categories/{category}`               | Displays a specific category.                                 | `CategoryController@show`                |
| **PUT|PATCH** | `/api/categories/{category}`               | Updates a specific category.                                  | `CategoryController@update`              |
| **DELETE**    | `/api/categories/{category}`               | Deletes a specific category.                                  | `CategoryController@destroy`             |

---

## 💊 Medicines Routes

| Method        | URI                                         | Action                                                        | Controller                               |
|---------------|---------------------------------------------|--------------------------------------------------------------|------------------------------------------|
| **GET|HEAD**  | `/api/medicines`                           | Search for medicines.                                         | `MedicineController@search`             |
| **POST**      | `/api/medicines`                           | Adds a new medicine.                                          | `MedicineController@store`              |
| **POST**      | `/api/medicines/purchase`                 | Records a purchase of medicine.                               | `PurchaseController@purchase`           |
| **GET|HEAD**  | `/api/medicines/{medicine}`                | Shows details of a specific medicine.                          | `MedicineController@show`               |
| **PUT|PATCH** | `/api/medicines/{medicine}`                | Updates a specific medicine.                                  | `MedicineController@update`             |
| **DELETE**    | `/api/medicines/{medicine}`                | Deletes a specific medicine.                                  | `MedicineController@destroy`            |

---

## 🏢 Suppliers Routes

| Method        | URI                                         | Action                                                        | Controller                               |
|---------------|---------------------------------------------|--------------------------------------------------------------|------------------------------------------|
| **GET|HEAD**  | `/api/suppliers`                           | Lists all suppliers.                                          | `SupplierController@index`              |
| **POST**      | `/api/suppliers`                           | Adds a new supplier.                                          | `SupplierController@store`              |
| **GET|HEAD**  | `/api/suppliers/{supplier}`                | Displays details of a specific supplier.                      | `SupplierController@show`               |
| **PUT|PATCH** | `/api/suppliers/{supplier}`                | Updates a specific supplier.                                  | `SupplierController@update`             |
| **DELETE**    | `/api/suppliers/{supplier}`                | Deletes a specific supplier.                                  | `SupplierController@destroy`            |

---

## 👤 Users Routes

| Method        | URI                                         | Action                                                        | Controller                               |
|---------------|---------------------------------------------|--------------------------------------------------------------|------------------------------------------|
| **GET|HEAD**  | `/api/users`                               | Lists all users.                                              | `UserController@index`                  |
| **POST**      | `/api/users`                               | Creates a new user.                                           | `UserController@store`                  |
| **GET|HEAD**  | `/api/users/{user}`                        | Displays details of a specific user.                          | `UserController@show`                   |
| **PUT|PATCH** | `/api/users/{user}`                        | Updates a specific user.                                      | `UserController@update`                 |
| **DELETE**    | `/api/users/{user}`                        | Deletes a specific user.                                      | `UserController@destroy`                |

---

## 🔑 Authentication Routes

| Method        | URI                                         | Action                                                        | Controller                               |
|---------------|---------------------------------------------|--------------------------------------------------------------|------------------------------------------|
| **POST**      | `/api/login`                               | Authenticates a user and provides an API token.               | `AuthController@login`                   |
| **POST**      | `/api/logout`                              | Logs out the user and invalidates the token.                  | `AuthController@logout`                  |

---

## 🥧 CSRF Cookie Route

| Method        | URI                                         | Action                                                        | Controller                               |
|---------------|---------------------------------------------|--------------------------------------------------------------|------------------------------------------|
| **GET|HEAD**  | `/sanctum/csrf-cookie`                     | Sets the CSRF cookie for session security.                    | `Laravel\Sanctum\CsrfCookieController@show` |


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