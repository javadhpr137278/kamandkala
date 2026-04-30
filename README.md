# 🛍️ کمند کالا - فروشگاه اینترنتی با لاراول و بوتسترپ

[caminshop.ir](https://caminshop.ir) | [@kamandkala](https://instagram.com/kamandkala)

![Laravel Version](https://img.shields.io/badge/Laravel-11.x-red.svg)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3-purple.svg)
![PHP](https://img.shields.io/badge/PHP-8.2+-blue.svg)
![MySQL](https://img.shields.io/badge/MySQL-8.0-orange.svg)
![License](https://img.shields.io/badge/license-MIT-green.svg)

## 📌 معرفی پروژه

**کمند کالا** یک فروشگاه اینترنتی کامل و مقیاس‌پذیر است که با **Laravel** و **Bootstrap** طراحی و پیاده‌سازی شده است.  
امکانات جامع فروشگاهی، مدیریت آسان محصولات، سبد خرید حرفه‌ای و پنل مدیریت قدرتمند از ویژگی‌های اصلی این پروژه می‌باشند. پروژه در حال توسعه است و به‌روزرسانی‌های منظم دریافت می‌کند.

---

## ✨ امکانات فعلی

- 🧑‍💼 **سیستم احراز هویت کاربران** (ثبت‌نام، ورود، بازیابی رمز)
- 🛒 **سبد خرید با قابلیت افزودن/حذف/به‌روزرسانی تعداد**
- 📦 **مدیریت محصولات** (دسته‌بندی، برند، قیمت، تخفیف، انبار)
- 🔍 **جستجو و فیلتر پیشرفته محصولات**
- 🖼 **گالری تصاویر محصول**
- 🧾 **فرآیند ثبت سفارش و صورت‌حساب**
- 💳 **اتصال به درگاه پرداخت زرین‌پال** (قابل تغییر)
- 📊 **پنل مدیریت کامل** (مدیریت سفارشات، محصولات، کاربران و تخفیف‌ها)
- 🌙 **حالت نمایش تاریک/روشن (رسمی)**
- 📱 **طراحی واکنش‌گرا (Responsive) با Bootstrap 5**
- 🗂 **مدیریت محتوا (صفحات تماس با ما، درباره ما، راهنما)**

---

## 🧱 تکنولوژی‌های استفاده شده

| بخش            | تکنولوژی                          |
|----------------|-----------------------------------|
| Backend        | PHP 8.2+, Laravel 11              |
| Frontend       | Blade, Bootstrap 5, jQuery (ساده) |
| Database       | MySQL 8.0                         |
| Authentication | Laravel Breeze / Sanctum (بر حسب نیاز) |
| Payment        | Zarinpal API                      |
| Version Control| Git & GitHub                      |

> همچنین از پکیج‌های مفید مانند `Intervention Image`، `Laravel Debugbar` و `Spatie Permission` استفاده شده است.

---

## 🚀 نحوه نصب و اجرا

### پیش‌نیازها
- PHP 8.2+
- Composer
- MySQL
- Node.js & NPM (برای کامپایل asset‌ها، در صورت نیاز)

### مراحل نصب

```bash
# 1. کلون کردن مخزن
git clone https://github.com/[your-username]/kamandkala.git
cd kamandkala

# 2. نصب وابستگی‌های PHP
composer install

# 3. کپی فایل محیطی و تنظیمات
cp .env.example .env

# 4. تولید کلید اپلیکیشن
php artisan key:generate

# 5. تنظیم اطلاعات دیتابیس در فایل .env
DB_DATABASE=kamandkala
DB_USERNAME=root
DB_PASSWORD=

# 6. اجرای migrations و سیدرها (برای داده‌های اولیه)
php artisan migrate --seed

# 7. لینک storage برای نمایش تصاویر
php artisan storage:link

# 8. اجرای سرور توسعه
php artisan serve

# اکنون می‌توانید در آدرس http://localhost:8000 مشاهده کنید
