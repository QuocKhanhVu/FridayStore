# Hướng dẫn cập nhật nhiều kho

Bản này đã chỉnh hệ thống theo mô hình nhiều kho:

- Admin hệ thống chỉ quản lý tài khoản kho tại `/system/users`.
- Tài khoản kho đăng nhập tại `/login` và vào `/admin/dashboard`.
- Dữ liệu kho được tách bằng cột `user_id`.
- Dữ liệu cũ được gán vào tài khoản kho mặc định:
  - Email: `oldwarehouse@fridaystore.vn`
  - Mật khẩu: `123456`
- Admin mặc định:
  - Email: `admin@fridaystore.vn`
  - Mật khẩu: `admin123456`

## Lệnh cần chạy sau khi thay code

```bash
composer dump-autoload
php artisan optimize:clear
php artisan migrate
```

Nếu muốn tạo lại tài khoản admin/kho dữ liệu cũ bằng seeder:

```bash
php artisan db:seed --class=AdminUserSeeder
```

## Kiểm tra

```bash
php artisan route:list | findstr login
php artisan route:list | findstr system.users
php artisan route:list | findstr inventory.damage
```

## Ghi chú kỹ thuật

Các model dữ liệu kho dùng trait:

```php
App\Models\Concerns\BelongsToWarehouse
```

Trait này tự động:

- Khi tài khoản `warehouse` truy vấn dữ liệu, chỉ lấy dòng có `user_id = auth()->id()`.
- Khi tài khoản `warehouse` tạo dữ liệu mới, tự gán `user_id = auth()->id()`.
- Khi chạy seeder trong console, dữ liệu mẫu được gán vào kho dữ liệu cũ nếu tài khoản `oldwarehouse@fridaystore.vn` tồn tại.

Các bảng đã thêm `user_id`:

- `costume_categories`
- `costumes`
- `costume_sizes`
- `size_rules`
- `inventories`
- `inventory_imports`
- `inventory_logs`
- `concepts`
- `studios`
- `rentals`
- `rental_extra_items`
- `rental_students`
- `rental_student_sizes`
- `rental_revenues`

Ngoài ra, unique mã trang phục đã đổi từ unique toàn hệ thống sang unique theo từng kho: `user_id + code`.
