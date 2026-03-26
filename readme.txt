Coffee and Contemplation

A Laravel-based blogging platform built as a finals project. Covers core blog functionality including post management, user authentication, and commenting. Shared authorship is partially implemented.

Tech Stack
Framework: Laravel 11.x
Language: PHP ^8.2
Frontend: Blade + Tailwind CSS v4 + Flowbite
Build Tool: Vite 5
Database: MySQL
Session / Cache / Queue: Database driver

Requirements
- PHP >= 8.2
- Composer
- Node.js >= 18 & npm
- MySQL

Installation
Run the following in your terminal:

git clone https://github.com/DWP-finals/finals-blog.git
cd finals-blog

(Install PHP dependencies)
composer install

(Install frontend dependencies)
npm install

(Set up your environment file)
cp example.env .env
php artisan key:generate

(Open .env and fill in your MySQL credentials)
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=finals_blog
DB_USERNAME=root
DB_PASSWORD=your_password

(Run migrations)
php artisan migrate

(Build frontend assets)
npm run build

(Start the development server)
php artisan serve

Then visit http://localhost:8000

Features
- User Authentication - Register, log in, and log out
- Post Management - Create, read, update, and delete blog posts
- Commenting - Users can comment on posts
- Author Profiles - Posts are associated with their author
- Shared Authorship (Partial) - See known limitations

Known Limitations

Currently shared authorship is not fully functional. Co-authorship assignment may exist in the data layer, but collaborative editing, permission checks between co-authors, and related notifications are not yet implemented.

Project Structure:

app/
├── Http/
│   └── Controllers/        # Application controllers
├── Models/                 # Eloquent models
database/
├── migrations/             # Database schema
└── seeders/                # Seed data
resources/
├── views/                  # Blade templates
└── css / js                # Frontend assets (compiled via Vite)
routes/
└── web.php                 # Web routes
example.env                 # Environment variable template

