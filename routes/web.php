<?php

use App\Http\Controllers\DateController;
use App\Http\Controllers\DemoController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\UserController;
use App\Http\Controllers\GodownController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\MachineController;

use App\Http\Controllers\UserRoleController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\LedgerController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ItemGroupController;
use App\Http\Controllers\ItemCategoryController;
use App\Http\Controllers\ManufacturingController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\VchG2GController;
use App\Http\Controllers\VchG2GItemController;
use App\Http\Controllers\VchGstSalePurchaseController;
use App\Http\Controllers\VchItemController;
use App\Http\Controllers\VchJournalController;
use App\Http\Controllers\VchJournalItemController;
use App\Http\Controllers\VchMfgController;
use App\Http\Controllers\VchMfgItemController;
use App\Http\Controllers\VchSalePurchaseController;
use App\Http\Controllers\VchPaymentReceiptController;
use App\Http\Controllers\VchStockJournalController;
use App\Http\Controllers\VchStockJournalItemController;
use App\Http\Controllers\AttendanceController;
use App\Models\VchItem;
use App\Models\VchMfg;
use App\Models\VchStockJournal;
use App\Http\Controllers\AuthController; // Adjust the namespace as needed
use App\Http\Controllers\EmployeeExpensesController;
use App\Http\Controllers\MpinController;
use App\Http\Middleware\CheckMpin;


require __DIR__.'/admin.php';

Auth::routes();

Route::middleware(['web', 'auth'])->group(function () {

    Route::resource('/user', UserController::class);

    Route::get('user/{id}/changePassword', [UserController::class,'changePassword'])->name('user.change.password');
    Route::post('/user/{id}/password/update', [UserController::class, 'updatePassword'])->name('user.password.update');
    Route::post('user/{id}/block', [UserController::class,'block'])->name('user.block');
    Route::post('user/{id}/unblock', [UserController::class,'unblock'])->name('user.unblock');

});

Route::prefix('admin')->middleware(['auth'])->group(function () {
});
