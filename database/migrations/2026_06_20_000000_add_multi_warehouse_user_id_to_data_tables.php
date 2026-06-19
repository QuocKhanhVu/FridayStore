<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private array $ownedTables = [
        'costume_categories',
        'costumes',
        'costume_sizes',
        'size_rules',
        'inventories',
        'inventory_imports',
        'inventory_logs',
        'concepts',
        'studios',
        'rentals',
        'rental_extra_items',
        'rental_students',
        'rental_student_sizes',
        'rental_revenues',
    ];

    public function up(): void
    {
        foreach ($this->ownedTables as $tableName) {
            if (! Schema::hasTable($tableName) || Schema::hasColumn($tableName, 'user_id')) {
                continue;
            }

            Schema::table($tableName, function (Blueprint $table) {
                $table->foreignId('user_id')
                    ->nullable()
                    ->after('id')
                    ->constrained('users')
                    ->nullOnDelete();
            });
        }

        $oldWarehouseId = $this->ensureOldWarehouseUser();

        $this->assignOldDataToWarehouse($oldWarehouseId);
        $this->adjustCostumeCodeUniqueIndex();
    }

    public function down(): void
    {
        $this->restoreCostumeCodeUniqueIndex();

        foreach (array_reverse($this->ownedTables) as $tableName) {
            if (! Schema::hasTable($tableName) || ! Schema::hasColumn($tableName, 'user_id')) {
                continue;
            }

            Schema::table($tableName, function (Blueprint $table) {
                $table->dropConstrainedForeignId('user_id');
            });
        }
    }

    private function ensureOldWarehouseUser(): int
    {
        $email = 'oldwarehouse@fridaystore.vn';

        $existingId = DB::table('users')
            ->where('email', $email)
            ->value('id');

        if ($existingId) {
            return (int) $existingId;
        }

        return (int) DB::table('users')->insertGetId([
            'name' => 'Kho dữ liệu cũ',
            'email' => $email,
            'password' => Hash::make('123456'),
            'role' => 'warehouse',
            'is_active' => true,
            'paid_until' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    private function assignOldDataToWarehouse(int $oldWarehouseId): void
    {
        foreach ([
            'costume_categories',
            'costumes',
            'concepts',
            'studios',
            'rentals',
            'inventory_imports',
        ] as $tableName) {
            $this->assignNullUserRows($tableName, $oldWarehouseId);
        }

        $this->copyUserIdFromParent('costume_sizes', 'costume_id', 'costumes');
        $this->copyUserIdFromParent('size_rules', 'costume_size_id', 'costume_sizes');
        $this->copyUserIdFromParent('inventories', 'costume_id', 'costumes');
        $this->copyUserIdFromParent('inventory_logs', 'costume_id', 'costumes');
        $this->copyUserIdFromParent('rental_extra_items', 'rental_id', 'rentals');
        $this->copyUserIdFromParent('rental_students', 'rental_id', 'rentals');
        $this->copyUserIdFromParent('rental_student_sizes', 'rental_student_id', 'rental_students');
        $this->copyUserIdFromParent('rental_revenues', 'rental_id', 'rentals');

        foreach ($this->ownedTables as $tableName) {
            $this->assignNullUserRows($tableName, $oldWarehouseId);
        }
    }

    private function assignNullUserRows(string $tableName, int $userId): void
    {
        if (! Schema::hasTable($tableName) || ! Schema::hasColumn($tableName, 'user_id')) {
            return;
        }

        DB::table($tableName)
            ->whereNull('user_id')
            ->update([
                'user_id' => $userId,
                'updated_at' => now(),
            ]);
    }

    private function copyUserIdFromParent(string $childTable, string $foreignKey, string $parentTable): void
    {
        if (! Schema::hasTable($childTable)
            || ! Schema::hasTable($parentTable)
            || ! Schema::hasColumn($childTable, 'user_id')
            || ! Schema::hasColumn($parentTable, 'user_id')) {
            return;
        }

        DB::statement("\n            UPDATE {$childTable} child\n            JOIN {$parentTable} parent ON parent.id = child.{$foreignKey}\n            SET child.user_id = parent.user_id\n            WHERE child.user_id IS NULL\n        ");
    }

    private function adjustCostumeCodeUniqueIndex(): void
    {
        if (! Schema::hasTable('costumes') || ! Schema::hasColumn('costumes', 'user_id')) {
            return;
        }

        try {
            $oldIndex = DB::select("SHOW INDEX FROM costumes WHERE Key_name = 'costumes_code_unique'");

            if (! empty($oldIndex)) {
                DB::statement('ALTER TABLE costumes DROP INDEX costumes_code_unique');
            }

            $newIndex = DB::select("SHOW INDEX FROM costumes WHERE Key_name = 'costumes_user_id_code_unique'");

            if (empty($newIndex)) {
                Schema::table('costumes', function (Blueprint $table) {
                    $table->unique(['user_id', 'code'], 'costumes_user_id_code_unique');
                });
            }
        } catch (Throwable $e) {
            // Nếu database không hỗ trợ SHOW INDEX, bỏ qua để không làm hỏng migrate.
        }
    }

    private function restoreCostumeCodeUniqueIndex(): void
    {
        if (! Schema::hasTable('costumes')) {
            return;
        }

        try {
            $newIndex = DB::select("SHOW INDEX FROM costumes WHERE Key_name = 'costumes_user_id_code_unique'");

            if (! empty($newIndex)) {
                DB::statement('ALTER TABLE costumes DROP INDEX costumes_user_id_code_unique');
            }

            $oldIndex = DB::select("SHOW INDEX FROM costumes WHERE Key_name = 'costumes_code_unique'");

            if (empty($oldIndex)) {
                Schema::table('costumes', function (Blueprint $table) {
                    $table->unique('code', 'costumes_code_unique');
                });
            }
        } catch (Throwable $e) {
            // Bỏ qua khi rollback trên database không hỗ trợ SHOW INDEX.
        }
    }
};
