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
Route::resource('mpin', MpinController::class);

Route::middleware(['web', 'auth'])->group(function () {
    Route::get('/auth/mpin', [App\Http\Controllers\MpinController::class, 'index'])->name('auth.lock');
    Route::post('/auth/mpin', [App\Http\Controllers\MpinController::class, 'mpin'])->name('auth.mpin');

    Route::middleware([CheckMpin::class])->group(function () {
        Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
        Route::get('/', function () {
            return redirect()->route('home');
        });
        Route::get('/demo', [App\Http\Controllers\DemoController::class, 'index']);
    });
    Route::resource('/group', GroupController::class);
    Route::resource('/machine', MachineController::class);
    Route::resource('/godown', GodownController::class);
    Route::resource('/ledger', LedgerController::class);
    Route::resource('/role', UserRoleController::class);
    Route::post('/emp-expenses/destory/{id}', [EmployeeExpensesController::class, 'expense_destory'])->name('Employee_Expenses.destory');
    Route::get('/emp-expenses/edit/{id}', [EmployeeExpensesController::class, 'expense_edit'])->name('Employee_Expenses.expense_edit');
    Route::post('/emp-expenses/update/{id}', [EmployeeExpensesController::class, 'expense_update'])->name('Employee_Expenses.expense_update');

    Route::get('/emp-expenses/verify-employee-expense/{id}', [EmployeeExpensesController::class, 'verify_employee_expense'])->name('Employee_Expenses.verify_employee_expense');
    Route::post('/emp-expenses/verify-employee-expense-save/{id}', [EmployeeExpensesController::class, 'verify_employee_expense_save'])->name('Employee_Expenses.verify_employee_expense_save');

    Route::get('/emp-expenses/verify-employee/', [EmployeeExpensesController::class, 'verify_expense'])->name('Employee_Expenses.verify_expense');
    Route::resource('/emp-expenses', EmployeeExpensesController::class);
    Route::get('/company', [CompanyController::class, 'index'])->name('company.edit');
    Route::get('/change-password', [CompanyController::class, 'change_password'])->name('changepassword');
    Route::post('/change-password-save', [CompanyController::class, 'change_password_save'])->name('changepassword.save');

    Route::put('/company/update/{company}', [CompanyController::class, 'update'])->name('company.update');

    Route::resource('/vchg2g', VchG2GController::class);
    Route::get('vch-g2g/', [VchG2GItemController::class, 'index'])->name('vchg2g.item.index');
    Route::get('vch-g2g/create', [VchG2GItemController::class, 'create'])->name('vchg2g.item.create');
    Route::get('vch-g2g/list', [VchG2GItemController::class, 'list'])->name('vchg2g.item.list');
    Route::get('vch-g2g/delete/{id}', [VchG2GItemController::class, 'delete'])->name('vchg2g.item.delete');

    Route::resource('/vchstockjournal', VchStockJournalController::class);
    Route::get('vch-stock-journal/', [VchStockJournalItemController::class, 'index'])->name('vchstockjournal.item.index');
    Route::get('vch-stock-journal/create', [VchStockJournalItemController::class, 'create'])->name('vchstockjournal.item.create');
    Route::get('vch-stock-journal/list', [VchStockJournalItemController::class, 'list'])->name('vchstockjournal.item.list');
    Route::get('vch-stock-journal/delete/{id}', [VchStockJournalItemController::class, 'delete'])->name('vchstockjournal.item.delete');

    Route::resource('/vchjournal', VchJournalController::class);
    Route::get('vch-journal/', [VchJournalItemController::class, 'index'])->name('vchjournal.index');
    Route::get('vch-journal/createItem', [VchJournalItemController::class, 'create'])->name('vchjournal.item.create');
    Route::get('vch-journal/list', [VchJournalItemController::class, 'list'])->name('vchjournal.item.data');
    Route::get('vch-journal/delete/{id}', [VchJournalItemController::class, 'delete'])->name('vchjournal.delete');

    Route::resource('/vchmfg', VchMfgController::class);
    Route::get('vch-mfg/', [VchMfgItemController::class, 'index'])->name('vchmfg.item.index');
    Route::get('vch-mfg/create', [VchMfgItemController::class, 'create'])->name('vchmfg.item.create');
    Route::get('vch-mfg/list', [VchMfgItemController::class, 'list'])->name('vchmfg.item.list');
    Route::get('vch-mfg/delete', [VchMfgItemController::class, 'delete'])->name('vchmfg.item.delete');

    Route::get('/convert-salary-to-transactions', [UserController::class, 'convertSalaryToTransactions'])->name('user.convert_salary_to_transactions');

    Route::get('/user/reset-password/{id}', [UserController::class, 'reset_password'])->name('user.reset_password');
    Route::get('/user/reset-mpin/{id}', [UserController::class, 'reset_mpin'])->name('user.reset_mpin');
    Route::get('/user/permission/{id}', [UserController::class, 'permission'])->name('user.permission');
    Route::post('/user/permission-save/{id}', [UserController::class, 'permission_save'])->name('user.permission_save');

    Route::get('/user/emp-attendance', [UserController::class, 'emp_attendance'])->name('user.emp-attendance');
    Route::get('/user/genrate-salary', [UserController::class, 'generate_salary'])->name('user.generate_salary');
    Route::post('/user/genrate-salary-view', [UserController::class, 'generate_salary_view'])->name('user.generate_salary_view');

    Route::post('/user/emp-attendance-save', [UserController::class, 'emp_attendance_save'])->name('user.emp-attendance-save');
    Route::post('/save-attendance', [AttendanceController::class, 'saveAttendance'])->name('attendance.save');

    Route::resource('/user', UserController::class);

    Route::get('user/{id}/changePassword', [UserController::class,'changePassword'])->name('user.change.password');
    Route::post('/user/{id}/password/update', [UserController::class, 'updatePassword'])->name('user.password.update');
    Route::post('user/{id}/block', [UserController::class,'block'])->name('user.block');
    Route::post('user/{id}/unblock', [UserController::class,'unblock'])->name('user.unblock');


    Route::prefix('items')->group(function () {
        Route::resource('item', ItemController::class)->names([
            'index' => 'item.index',
            'create' => 'item.create',
            'store' => 'item.store',
            'show' => 'item.show',
            'edit' => 'item.edit',
            'update' => 'item.update',
            'destroy' => 'item.destroy'

        ]);
        Route::resource('/group', ItemGroupController::class)->names([
            'index' => 'item_group.index',
            'create' => 'item_group.create',
            'store' => 'item_group.store',
            'show' => 'item_group.show',
            'edit' => 'item_group.edit',
            'update' => 'item_group.update',
            'destroy' => 'item_group.destroy'

        ]);
        Route::resource('/category', ItemCategoryController::class)->names([
            'index' => 'item.category.index',
            'create' => 'item.category.create',
            'store' => 'item.category.store',
            'show' => 'item.category.show',
            'edit' => 'item.category.edit',
            'update' => 'item.category.update',
            'destroy' => 'item.category.destroy'

        ]);
        Route::resource('/unit', UnitController::class)->names([
            'index' => 'item.unit.index',
            'create' => 'item.unit.create',
            'store' => 'item.unit.store',
            'show' => 'item.unit.show',
            'edit' => 'item.unit.edit',
            'update' => 'item.unit.update',
            'destroy' => 'item.unit.destroy'

        ]);
        Route::get('/bom/{bom}', [ItemController::class, 'bom'])->name('item.bom.create');
        Route::post('/bom/store', [ItemController::class, 'bom_store'])->name('item.bom.store');
        Route::delete('/delete/{bom}/{item_id}', [ItemController::class, 'bom_delete'])->name('item.bom.delete');
    });

    Route::get('vch-pr/{vch_type}', [VchPaymentReceiptController::class, 'index'])->name('vch.pr.index');
    Route::get('vch-pr/{vch_type}/create', [VchPaymentReceiptController::class, 'create'])->name('vch.pr.create');
    Route::post('vch-pr/{vch_type}', [VchPaymentReceiptController::class, 'store'])->name('vch.pr.store');
    //Route::get('vch-gst/{vch_type}/{voucher}', [VchGstSalePurchaseController::class, 'show'])->name('vch.gst.show');
    Route::get('vch-pr/{vch_type}/{voucher}/edit', [VchPaymentReceiptController::class, 'edit'])->name('vch.pr.edit');
    Route::put('vch-pr/{vch_type}/{voucher}', [VchPaymentReceiptController::class, 'update'])->name('vch.pr.update');
    Route::delete('vch-pr/{vch_type}/{voucher}', [VchPaymentReceiptController::class, 'destroy'])->name('vch.pr.delete');


    Route::get('vch-gst/{vch_type}', [VchGstSalePurchaseController::class, 'index'])->name('vch.gst.index');
    Route::get('vch-gst/{vch_type}/create', [VchGstSalePurchaseController::class, 'create'])->name('vch.gst.create');
    Route::post('vch-gst/{vch_type}', [VchGstSalePurchaseController::class, 'store'])->name('vch.gst.store');
    //Route::get('vch-gst/{vch_type}/{voucher}', [VchGstSalePurchaseController::class, 'show'])->name('vch.gst.show');
    Route::get('vch-gst/{vch_type}/{voucher}/edit', [VchGstSalePurchaseController::class, 'edit'])->name('vch.gst.edit');
    Route::put('vch-gst/{vch_type}/{voucher}', [VchGstSalePurchaseController::class, 'update'])->name('vch.gst.update');
    Route::delete('vch-gst/{vch_type}/{voucher}', [VchGstSalePurchaseController::class, 'destroy'])->name('vch.gst.destroy');

    Route::get('vch-gst/{vch_type}/{id}', [VchGstSalePurchaseController::class, 'order_to_sale'])->name('order.gst.to.sale');

    Route::get('vch-sp/{vch_type}', [VchSalePurchaseController::class, 'index'])->name('vch.index');
    Route::get('vch-sp/{vch_type}/create', [VchSalePurchaseController::class, 'create'])->name('vch.create');
    Route::post('vch-sp/{vch_type}', [VchSalePurchaseController::class, 'store'])->name('vch.store');
    //Route::get('vch-gst/{vch_type}/{voucher}', [VchGstSalePurchaseController::class, 'show'])->name('vch.gst.show');
    Route::get('vch-sp/{vch_type}/{voucher}/edit', [VchSalePurchaseController::class, 'edit'])->name('vch.edit');
    Route::put('vch-sp/{vch_type}/{voucher}', [VchSalePurchaseController::class, 'update'])->name('vch.update');
    Route::delete('vch-sp/{vch_type}/{voucher}', [VchSalePurchaseController::class, 'destroy'])->name('vch.destroy');
    //    Route::get('vch-sp/{vch_type}/order/{orderId}', [VchSalePurchaseController::class, 'order_to_sale'])->name('order.to.sale');
    Route::get('vch-sp/{vch_type}/{id}', [VchGstSalePurchaseController::class, 'order_to_sale'])->name('order.to.sale');

    Route::get('vch-item/', [VchItemController::class, 'index'])->name('vch.item.index');
    Route::get('vch-item/create', [VchItemController::class, 'create'])->name('vch.item.create');
    Route::get('vch-item/list/{type}', [VchItemController::class, 'list'])->name('vch.item.list');
    Route::get('vch-item/delete', [VchItemController::class, 'delete'])->name('vch.item.delete');

    Route::get('vch-journal/', [VchJournalController::class, 'index'])->name('vch.journal.index');
    Route::get('vch-journal/create', [VchJournalController::class, 'create'])->name('vch.journal.create');
    Route::get('vch-journal/data/{type}', [VchJournalController::class, 'data'])->name('vch.journal.data');
    Route::get('vch-journal/delete/{id}', [VchJournalController::class, 'delete'])->name('vch.journal.delete');

    Route::get('date/change', [DateController::class, 'change_date'])->name('date.change');
    Route::get('date', [DateController::class, 'index']);

    Route::get('report/ledger', [ReportsController::class, 'report'])->name('report.ledger');
    Route::post('report/ledger', [ReportsController::class, 'generateReport'])->name('report.generateReport');

    Route::get('report/', [ReportsController::class, 'index'])->name('report.index');
    Route::get('report/inactive', [ReportsController::class, 'inactive'])->name('report.inactive');
    Route::get('report/inactivereport', [ReportsController::class, 'inactivereport'])->name('report.inactivereport');
    Route::get('report/groupname', [ReportsController::class, 'groupname'])->name('report.groupname');
    Route::get('report/bank', [ReportsController::class, 'bank'])->name('report.bank');
    Route::get('report/minstockqty', [ReportsController::class, 'minstockqty'])->name('report.minstockqty');
    Route::get('report/order', [ReportsController::class, 'order'])->name('report.order');
    Route::get('report/customer', [ReportsController::class, 'customer'])->name('customer.report');
    Route::get('report/ordersummary', [ReportsController::class, 'ordersummaryview'])->name('order.summary.view');
    Route::post('report/ordersummary/show', [ReportsController::class, 'ordersummary'])->name('order.summary');
    Route::get('report/godownstock', [ReportsController::class, 'godownstock'])->name('report.godownstock');
    Route::get('report/godownstock_report', [ReportsController::class, 'godownstock_report'])->name('report.godownstock_report');

    Route::get('report/minstockqty', [ReportsController::class, 'minstockqtyview'])->name('report.minstockqty.view');

    Route::post('report/minstockqty/show', [ReportsController::class, 'minstockqty'])->name('report.minstockqty');

    Route::get('report/ordersaledifference', [ReportsController::class, 'ordersaledifferenceview'])->name('report.ordersaledifference.view');
    Route::post('report/ordersaledifference/show', [ReportsController::class, 'ordersaledifference'])->name('report.ordersaledifference');
    Route::get('report/highestcustomer', [ReportsController::class, 'highestcustomer'])->name('report.highestcustomer');
    Route::get('report/type', [ReportsController::class, 'type'])->name('type.report');
    Route::get('report/group', [ReportsController::class, 'groupindex'])->name('report.group');
    Route::get('report/groupreport', [ReportsController::class, 'groupreport'])->name('report.groupreport');
    Route::get('report/ledgerview/{id}', [ReportsController::class, 'ledgerview'])->name('report.ledgerview');
    Route::get('report/voucher', [ReportsController::class, 'voucherindex'])->name('report.voucher.view');
    Route::post('report/voucher/show', [ReportsController::class, 'voucherreport'])->name('report.voucher');

    Route::get('report/payable', [ReportsController::class, 'payableview'])->name('report.payable.view');

    Route::post('report/payable/show', [ReportsController::class, 'payable'])->name('report.payable');
    Route::get('report/report30daysdebtors', [ReportsController::class, 'report30daysdebtors'])->name('report.report30daysdebtors');
    Route::get('report/receivable', [ReportsController::class, 'receivableview'])->name('report.receivable.view');
    Route::post('report/receivable/show', [ReportsController::class, 'receivable'])->name('report.receivable');
    Route::get('report/day', [ReportsController::class, 'day'])->name('report.day');
    Route::get('report/trail-balance', [ReportsController::class, 'trail_balance_view'])->name('report.trail-balance.view');
    Route::post('report/trail-balance/show', [ReportsController::class, 'trail_balance'])->name('report.trail-balance');
    Route::get('report/{vch_type}', [ReportsController::class, 'sale_report'])->name('report.sale.monthly');
});

Route::prefix('admin')->middleware(['auth'])->group(function () {
});
