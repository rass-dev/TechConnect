
<p align="center">
  <img src="Screenshots/logo.jpg" width="120"/>
</p>

<h2 align="center">TechConnect E-Commerce & Inventory System</h2>

---

## Info

TechConnect is a Laravel-based e-commerce and inventory system designed for electronics and accessories. It enables users to browse products, add items to cart, and place orders with automated email PDF receipts. Administrators can manage inventory, monitor sales, and generate reports through a centralized dashboard.

---

## Features

- Product browsing and catalog system
- Shopping cart and checkout process
- Automated email PDF receipt generation
- Inventory and stock management
- Admin dashboard with sales analytics
- Sales tracking and reporting
- Product and category management
- User authentication and role-based access

---

## Tech Stack

- **Backend:** PHP (Laravel)
- **Frontend:** HTML, CSS, JavaScript
- **Database:** MySQL
- **Tools:** XAMPP / Laragon

---

## 🖼️ Screenshots

<table>
<tr>
<td align="center">
<img src="Screenshots/logo.jpg" width="120"/>

### Logo

Represents the official branding and identity of TechConnect.
</td>
</tr>
</table>

<br>

<table>
<tr>

<td width="50%" valign="top">

<img src="Screenshots/home-page.png"/>

### Home Page

Serves as the main landing page, showcasing featured products, promotions, and store services.

</td>

<td width="50%" valign="top">

<img src="Screenshots/about-page.png"/>

### About Page

Displays information about TechConnect, including its purpose, features, and company branding.

</td>

</tr>

<tr>

<td width="50%" valign="top">

<img src="Screenshots/products-page.png"/>

### Products Page

Allows users to browse products and filter them by category, brand, and price range.

</td>

<td width="50%" valign="top">

<img src="Screenshots/contact-page.png"/>

### Contact Page

Enables customers to send inquiries and view the company's contact details and location.

</td>

</tr>

<tr>

<td width="50%" valign="top">

<img src="Screenshots/paypal-checkout-page.png"/>

### PayPal Checkout Page

Displays the PayPal payment gateway where users can securely complete their purchases.

</td>

<td width="50%" valign="top">

<img src="Screenshots/order-details-page.png"/>

### Order Details Page

Shows the complete order summary, shipping information, payment status, and purchased items.

</td>

</tr>

<tr>

<td colspan="2" align="center">

<img src="Screenshots/admin-dashboard-page.png"/>

### Admin Dashboard

Provides administrators with an overview of users, orders, revenue, and payment analytics.

</td>

</tr>
</table>

---

## Installation & Setup

### 1. Clone the Repository

```bash
git clone https://github.com/rass-dev/TechConnect.git
cd TechConnect
````

### 2. Install Dependencies

```bash
composer install
```

### 3. Setup Environment File

```bash
cp .env.example .env
```

### 4. Configure Database

Open `.env` file and update:

```env
DB_DATABASE=techconnect
DB_USERNAME=root
DB_PASSWORD=
```

---

### 4.1 Import Database (Recommended)

A ready-to-use database file is included in the project.

1. Open **phpMyAdmin**
2. Create a database named `techconnect`
3. Go to **Import** tab
4. Select the SQL file from:

```
TechConnect/techconnect_backup.sql
```

5. Click **Import**

---

### 5. Initialize Application

```bash
php artisan key:generate
```

*(Skip migrate if using provided database)*

```bash
php artisan migrate
```

*(Optional)*

```bash
php artisan db:seed
```

---

### 6. Start the Server

```bash
php artisan serve
```

---

## Usage

### Access the system:

http://127.0.0.1:8000

### User

* Browse products
* Add to cart
* Checkout
* Receive email receipt

### Admin

* Manage products and categories
* Monitor sales
* View reports and dashboard

---

## 🔐 Notes

* Make sure XAMPP/Laragon and MySQL are running.
* Ensure `.env` is properly configured.
* A ready-to-use database file is included in the project.
* Email feature may require mail configuration.
* PayPal integration may require API credentials for production.

---

## Developer

**Ras D.P. Sanchez**

Bachelor of Science in Information Technology

GitHub: https://github.com/rass-dev

```
