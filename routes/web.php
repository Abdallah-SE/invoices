<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AdminController;

use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\SectionsController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\InvoicesDetailsController;
use App\Http\Controllers\InvoicesAttachmentsController;

use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;


use App\Http\Controllers\InvoiceReportController;
use App\Http\Controllers\CustomerReportController;


use App\Http\Controllers\HomeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


/*Route::get('/', function () {
    return view('auth.login');
});*/

require __DIR__.'/auth.php';

Route::group(['middleware' => ['auth', 'verified_active_user']], function()
{
   Route::resource('invoices', InvoicesController::class);
   Route::resource('sections', SectionsController::class);
   Route::resource('products', ProductsController::class);
   Route::resource('roles', RoleController::class);
   Route::resource('users', UserController::class);
    
    
   Route::get('/section/{id}', [InvoicesController::class,'getProducts']);
   Route::get('/edit_invoice/{id}', [InvoicesController::class,'edit']);
   Route::get('/show_status/{id}', [InvoicesController::class,'show'])->name('Status_show');
   Route::post('/Status_Update/{id}', [InvoicesController::class,'statusUpdate'])->name('Status_Update');
   
   Route::get('/paid_invoice', [InvoicesController::class,'paid'])->name('paid_invoice');
   Route::get('/unpaid_invoice', [InvoicesController::class,'unpaid'])->name('unpaid_invoice');
   Route::get('/partial_invoice', [InvoicesController::class,'partial'])->name('partial_invoice');
   Route::get('/trashed_invoice', [InvoicesController::class,'trash'])->name('trashed_invoice');
   Route::patch('/cancel_trash', [InvoicesController::class,'cancel_trash'])->name('cancel_trash');
   Route::delete('/destroyTrash', [InvoicesController::class,'destroyTrash'])->name('destroy-trash');
   Route::get('/print_invoice/{id}', [InvoicesController::class,'printInvoice'])->name('print-invoice');
   Route::get('/export_invoices', [InvoicesController::class, 'export']);


   Route::get('/InvoicesDetails/{id}', [InvoicesDetailsController::class,'invoiceDetails']);
   Route::get('/InvoicesDetails/{id}', [InvoicesDetailsController::class,'invoiceDetails']);
   Route::get('/View_file/{invoice_number}/{file_name}', [InvoicesDetailsController::class,'openInvoiceFile']);
   Route::get('/download/{invoice_number}/{file_name}', [InvoicesDetailsController::class,'download']);
   Route::post('/delete_file', [InvoicesDetailsController::class,'destroy'])->name('delete_file');
   
   Route::post('/InvoiceAttachments', [InvoicesAttachmentsController ::class,'store'])->name('attach_file');
   
  
   
   /// Reports of the invoices
   
   Route::get('/invoices-reports',[InvoiceReportController::class, 'index'])->name('invoices-reports');
   Route::post('/invoices-reports-search',[InvoiceReportController::class, 'search'])->name('invoices-reports-search');
     
   Route::get('/customers-reports',[CustomerReportController::class, 'index'])->name('customers-reports');
   Route::post('/customers-reports-search',[CustomerReportController::class, 'search'])->name('customers-reports-search');
    
   
  Route::get('/dashboard/{lang}', [HomeController::class, 'index'])->name('dashboard');
  Route::get('/{lang}', [HomeController::class, 'index'])->name('dashboard');
  Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
  
  Route::get('/markAsRead', [InvoicesController::class, 'markAsRead'])->name('markAsRead');
  
});

/// Control spatie package through the route
/*Route::group(['middleware' => ['role:super-admin']], function () {
    //
});*/


Route::get('/{page}',[AdminController::class, 'index'])->name('page');
