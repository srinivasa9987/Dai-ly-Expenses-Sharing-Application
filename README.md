This application is designed to help users share daily expenses by splitting costs among participants using various methods (equal, exact amounts, and percentages). The backend is implemented using PHP, and the frontend is created using HTML, CSS, and JavaScript.

//FEATURES:
User Management:

Create a user with email, name, and mobile number.
Retrieve user details.

//Expense Management:

//Add expenses.

Split expenses equally, by exact amounts, or by percentages.
Balance Sheet:

//Show individual expenses.
Show overall expenses for all users.
Download the balance sheet.
Project Structure
lua
Copy code
expense-sharing-app/
|-- api/
|   |-- config.php
|   |-- user.php
|   |-- expense.php
|   |-- balance_sheet.php
|-- assets/
|   |-- css/
|   |   |-- style.css
|   |-- js/
|   |   |-- script.js
|-- frontend/
|   |-- index.html
|-- database.sql
|-- README.md

//Setup and Installation
Prerequisites
PHP 7.4 or later
Composer
MySQL or any other relational database
A web server (Apache, Nginx, etc.)
Backend Setup
Clone the repository:

sh
Copy code
git clone https://github.com/your-username/expense-sharing-app.git
cd expense-sharing-app
Install dependencies:

sh
Copy code
composer install
Configure the database:

//Create a new database.
Import the database.sql file to set up the necessary tables:
sh
Copy code
mysql -u yourusername -p yourpassword yourdatabase < database.sql
Update config.php with your database credentials.
Run the application:

Use a web server to serve the application or use the built-in PHP server for development:
sh
Copy code
php -S localhost:8000
Frontend Setup
Open the frontend/index.html file in your browser.
Usage
//Create a User:

Navigate to the "Create User" section and fill in the details.
Submit the form to create a user.
Add an Expense:

Navigate to the "Add Expense" section and fill in the details.
Submit the form to add an expense.
View Users and Expenses:

Users and expenses will be listed under their respective sections.
Download Balance Sheet:

//Use the provided feature to download the balance sheet as an Excel file.
API Endpoints
User Endpoints:

//POST /api/user.php - Create a new user.
GET /api/user.php?id={id} - Retrieve user details by ID.
Expense Endpoints:

//POST /api/expense.php - Add a new expense.
GET /api/expense.php - Retrieve all expenses.
GET /api/expense.php?id={id} - Retrieve expense details by ID.
Balance Sheet Endpoint:

//GET /api/balance_sheet.php - Download the balance sheet.
Technologies Used
Backend: PHP, MySQL
Frontend: HTML, CSS, JavaScript

//Additional Notes
Ensure to validate inputs both on the frontend and backend for security and data integrity.
Consider implementing authentication for secure access to the API endpoints.
For production, use a robust database system and optimize configurations for performance.

