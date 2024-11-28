# CALABARZON-SUC-LOCATOR

## **Introduction**
The **CALABARZON-SUC-LOCATOR** is a Laravel-based web application that allows users to manage and locate State Universities and Colleges (SUCs) using table and map views. This project demonstrates CRUD functionality, external package integration, and responsive design.

---

## **Prerequisites**
Ensure you have the following installed on your system:
- **PHP** (v8.0 or higher)
- **Composer** (latest version)
- **Laravel** (v10.x recommended)
- **Laragon**
- **Database**
- **Git**

---

## **Setup Instructions**

### **1. Clone the Repository**
- Before cloning, ensure you're on the master branch:
```bash
git checkout master
git clone https://github.com/alchowdhury71/CALABARZON-SUC-LOCATOR.git
cd CALABARZON-SUC-LOCATOR
```
### **2. Start Laragon**
- Launch Laragon and ensure the Apache and MySQL services are running.

### **3. Install Dependencies**
- Install PHP dependencies using Composer:
```bash
composer install
```
- Install JavaScript dependencies:
```bash
npm install
```

### **4. Environment Setup**
- Copy the `.env.example` file to `.env`:
```bash
cp .env.example .env
```
- Update the `.env` file with the following database configuration:
```.env  
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=root
DB_PASSWORD=

```
### **5. Generate Application Key**
- Run the following command to generate a new application key:
```bash
php artisan key:generate
```

### **6. Database Setup**
- Create a new database in MySQL using the Laragon database manager or terminal.
- Run migrations to set up the database schema:
```bash
php artisan migrate
```

### **7. Seed the Database**
- To populate your database with sample data, use the seeder:
```bash
php artisan db:seed --class=CollegeSeeder
```

### **8. Build Frontend Assets**
- Compile CSS and JavaScript assets:
```bash
npm run dev
```

### **9. Start the Development Server**
- Start Laravel's built-in server:
```
php artisan serve
```

The application will be accessible at http://127.0.0.1:8000.

---
## **Usage Instructions**

### **1. Access the Application**
Open the application in your browser at http://127.0.0.1:8000.
### **2. Manage SUCs**
Navigate to the Manage SUCs section to:
  - Add new SUCs using the "Add" button.
  - Edit or delete SUCs using the "Edit" or "Delete" options in the Table View.
  - Search SUCs
  - Locate SUCs using the "locate" option in the Table View.
### **3. Switch Views**
Use the toggle button to switch between:
  - **Table View**: Displays SUCs in a tabular format.
  - **Map View**: Displays SUCs as markers on a map.
### **4. View SUC Details**
Click on a marker in the Map View to view SUC details.

---
## **Additional Notes**

### **1. Laravel Maps Integration**
The application uses the [laravel-maps package](https://github.com/LarsWiegers/laravel-maps) for map functionality. Refer to their documentation for advanced configuration options.

### **2. Customization**
- To customize the frontend, edit the files in the `resources` directory (views, CSS, etc.).
- For backend logic, modify controllers in the `app/Http/Controllers` directory.

### **3. Troubleshooting**
- Ensure all dependencies are installed and the `.env` file is correctly configured.
- If you encounter issues, clear the cache:
```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```
---

## **License**
This project is open-source and available under the [MIT License](LICENSE).

---

## **Contributors**
- **Prince Aladdin Chowdhury**
- **Jann Rose Tiongco**
- **Radzmir Jose**
- **Jemuel Lopez**
