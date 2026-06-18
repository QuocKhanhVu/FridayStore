<?php

use App\Http\Controllers\Admin\Concept\ConceptController;
use App\Http\Controllers\admin\costumes\sizesController;
use App\Http\Controllers\admin\CostumesController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\Inventory\InventoryController;
use App\Http\Controllers\Admin\RentalController;
use App\Http\Controllers\Admin\RentalHistoryController;
use App\Http\Controllers\Admin\RentalManagementController;
use App\Http\Controllers\Admin\RentalStudentController;
use App\Http\Controllers\Admin\RevenueController;
use App\Http\Controllers\Admin\StudioController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\ReportController;
use App\Http\Controllers\admin\Inventory\InventoryDamageController;
Route::prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get(
            '/dashboard',
            [DashboardController::class,'index']
        )->name('dashboard');

        //WAREHOUSE
        Route::get(
            'costumes/export',
            [CostumesController::class, 'export']
        )->name('costumes.export');
            //INVENTORY
        Route::get(
            '/warehouse/inventory',
            [InventoryController::class,'index']
        )->name('inventory.index');
        Route::get(
            '/warehouse/inventory/create',
            [InventoryController::class,'create']
        )->name('inventory.create');

        Route::post(
            '/warehouse/inventory/store',
            [InventoryController::class,'store']
        )->name('inventory.store');
        Route::get('/inventory/damage', [InventoryDamageController::class, 'create'])
            ->name('inventory.damage.create');

        Route::post('/inventory/damage', [InventoryDamageController::class, 'store'])
            ->name('inventory.damage.store');
           // COSTUMES

        Route::get(
            '/warehouse/costumes',
            [CostumesController::class,'index']
        )->name('costumes.index');

        Route::get(
            '/warehouse/costumes/create',
            [CostumesController::class,'create']
        )->name('costumes.create');

        Route::post(
            '/warehouse/costumes/store',
            [CostumesController::class,'store']
        )->name('costumes.store');

        Route::get(
            '/warehouse/costumes/{costume}/edit',
            [CostumesController::class,'edit']
        )->name('costumes.edit');

        Route::put(
            '/warehouse/costumes/{costume}',
            [CostumesController::class,'update']
        )->name('costumes.update');

        Route::delete(
            '/warehouse/costumes/{costume}',
            [CostumesController::class,'destroy']
        )->name('costumes.destroy');
                    //SIZES
        Route::get(
            '/warehouse/sizes',
            [sizesController::class,'index']
        )->name('sizes.index');
        Route::get(
            '/warehouse/sizes/create',
            [sizesController::class,'create']
        )->name('sizes.create');
         Route::post(
            '/warehouse/sizes/store',
            [sizesController::class,'store']
        )->name('sizes.store');
        Route::get(
            '/warehouse/sizes/{costumeSize}/edit',
            [sizesController::class,'edit']
        )->name('sizes.edit');

        Route::put(
            '/warehouse/sizes/{costumeSize}',
            [sizesController::class,'update']
        )->name('sizes.update');

        Route::delete(
            '/warehouse/sizes/{costumeSize}',
            [sizesController::class,'destroy']
        )->name('sizes.destroy');
        Route::get(
            '/warehouse/inventory/export',
            [InventoryController::class,'export']
        )->name('inventory.export');
                 //Concept
        Route::resource(
            'concepts',
            ConceptController::class
        );
        Route::get(
            '/concepts',
            [ConceptController::class,'index']
        )->name('concepts.index');

        Route::get(
            '/concepts/create',
            [ConceptController::class,'create']
        )->name('concepts.create');

        Route::post(
            '/concepts/store',
            [ConceptController::class,'store']
        )->name('concepts.store');

        Route::get(
            '/concepts/{concept}/edit',
            [ConceptController::class,'edit']
        )->name('concepts.edit');

        Route::put(
            '/concepts/{concept}',
            [ConceptController::class,'update']
        )->name('concepts.update');

        Route::delete(
            '/concepts/{concept}',
            [ConceptController::class,'destroy']
        )->name('concepts.destroy');
        // STUDIO

        Route::get(
            '/studios',
            [StudioController::class, 'index']
        )->name('studios.index');

        Route::get(
            '/studios/create',
            [StudioController::class, 'create']
        )->name('studios.create');

        Route::post(
            '/studios/store',
            [StudioController::class, 'store']
        )->name('studios.store');

        Route::get(
            '/studios/{studio}/edit',
            [StudioController::class, 'edit']
        )->name('studios.edit');

        Route::put(
            '/studios/{studio}',
            [StudioController::class, 'update']
        )->name('studios.update');

        Route::delete(
            '/studios/{studio}',
            [StudioController::class, 'destroy']
        )->name('studios.destroy');
        // RENTALS

        Route::resource(
            'rentals',
            RentalController::class
        );

        // IMPORT STUDENTS

        Route::get(
            '/rentals/{rental}/students/import',
            [RentalStudentController::class,'create']
        )->name('rentals.students.create');

        Route::post(
            '/rentals/{rental}/students/import',
            [RentalStudentController::class,'store']
        )->name('rentals.students.store');

        Route::get(
            '/rentals/{rental}/students',
            [RentalStudentController::class,'index']
        )->name('rentals.students.index');
        // IMPORT AUTO LOAD SIZE
        Route::post(
            '/rentals/{rental}/auto-size',
            [RentalStudentController::class,'autoSize']
        )->name(
            'rentals.students.auto-size'
        );
        Route::get(
            '/rentals/{rental}/size-result',
            [RentalStudentController::class,'sizeResult']
        )->name(
            'rentals.students.size-result'
        );
        //export file auto-load
        Route::get(
            '/rentals/{rental}/export-size',
            [RentalStudentController::class,'export']
        )->name(
            'rentals.students.export'
        );
        Route::patch(
            'rental-student-sizes/{id}',
            [RentalManagementController::class, 'updateStudentSize']
        )->name('rental-student-sizes.update');
        //history
         //tại đây là lịch sử trong phần quản lý thuê đồ item thứ 3
        Route::get(
            '/rental-management',
            [RentalManagementController::class, 'index']
        )->name('rental-management.index');
        Route::patch(
            'rental-management/{rental}/status',
            [RentalManagementController::class,'updateStatus']
        )->name(
            'rental-management.status'
        );
        //tại đây là lịch sử trong phần quản lý thuê đồ item thứ 4
        Route::get(
        '/rental-history',
        [RentalHistoryController::class,'history']
        )->name('rental-history.history');
        Route::delete('/rental-history/{id}', [RentalHistoryController::class, 'destroy'])
        ->name('rental-history.destroy');
           //hiển thị thông tin chi tiết
        Route::get(
            '/rental-history/{rental}',
            [RentalManagementController::class,'show']
        )->name('rental-history.show');
        Route::get(
            '/ajax/costumes',
             [RentalController::class, 'getCostumes'])
        ->name('ajax.costumes');
        Route::get(
            'rental-history/{rental}/export',
            [RentalHistoryController::class, 'export']
        )->name(
            'rental-history.export'
        );
        //doanh thu
      

        Route::get(
            'revenues',
            [RevenueController::class, 'index']
        )->name('revenues.index');
        Route::get('/revenues/export', [RevenueController::class, 'export'])
        ->name('revenues.export');
        Route::delete('/revenues/{id}', [RevenueController::class, 'destroy'])
        ->name('revenues.destroy');
        //report
        Route::get('/reports', [ReportController::class, 'index'])
        ->name('reports.index');
}); 