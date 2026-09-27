# Laravel Livewire User Management

A modern, clean and fully responsive **User Management CRUD** application built with **Laravel + Livewire 4** (Single File Components).

Supports **Dark Mode** & **Light Mode**.

---

## Features

- Full CRUD (Create, Read, Update, Delete)
- Real-time Search
- Dark Mode / Light Mode toggle (with localStorage)
- Modern & Beautiful UI
- Responsive Design
- Single File Livewire Components
- Form Validation
- Confirmation before Delete

---

## Tech Stack

- Laravel 11 / 12
- Livewire 4 (Single File Components)
- Bootstrap 5.3
- Alpine.js (included with Livewire)

---


## Screenshots

| Light Mode | Dark Mode |
|------------|-----------|
| ![Light](screenshots/light.png) | ![Dark](screenshots/dark.png) |


---


## Installation

1. **Clone the repository**
```bash
git clone https://github.com/aungkyawthetakt052/laravel-livewire-user-management.git
cd laravel-livewire-user-management

## Create Users (Seeding)

You can quickly generate test users using Tinker:

### Create 100 Users
```bash
php artisan tinker
App\Models\User::factory()->count(100)->create();







