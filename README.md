# Quản lý Sản phẩm - Filament Admin

Hệ thống quản lý danh mục và sản phẩm sử dụng Laravel và Filament.

## Thông tin

- MSSV: 23810310112
- Họ tên: Nguyễn Văn Hiếu

## Công nghệ

- Laravel 12.x
- Filament v5.4
- SQLite

## Cài đặt

```bash
composer install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate
php artisan storage:link
php artisan make:filament-user
php artisan serve
```

Truy cập: http://localhost:8000/admin

## Tính năng

- Quản lý danh mục (CRUD, auto slug, filter)
- Quản lý sản phẩm (CRUD, Rich Editor, upload ảnh)
- Hiển thị giá VNĐ
- Tìm kiếm và lọc
- Trường warranty_period (thời gian bảo hành)
