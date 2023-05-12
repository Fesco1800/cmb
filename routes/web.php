<?php

use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\LandingPageServiceController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\ServicesController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ContactMessageController;
use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\NotificationController;

use App\Models\Maintenance;
use App\Models\AdminNotification;
use App\Models\Branch;
use App\Models\LandingPageService;
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

Route::get('/', function () {
    return view('welcome', [
        'details' => Maintenance::first(),
        'branches' => Branch::all(),
        'services' => LandingPageService::all()
    ]);
})->name('landingpage');

Auth::routes();

Route::prefix('users')->name('users.')->group(function() {

    Route::get('/index',[UserController::class, 'index'])->name('index');
    Route::get('/create',[UserController::class,'create'])->name('create');
    Route::get('/show/{user}',[UserController::class, 'show'])->name('show');
    Route::post('/store',[UserController::class,'store'])->name('store');
    Route::get('/destroy/{user}', [UserController::class,'destroy'])->name('destroy');
    Route::get('/edit/{user}', [UserController::class, 'edit'])->name('edit');
    Route::post('/update/{user}', [UserController::class,'update'])->name('update');
    Route::get('/change-password', [UserController::class,'changePassword'])->name('change-password');
    Route::post('/store-change-pass',[UserController::class,'storeChangepass'])->name('store-change-pass');
    Route::get('/editBarber/{user}', [UserController::class, 'editBarber'])->name('editBarber');
    Route::post('/barberUpdate/{user}', [UserController::class,'barberUpdate'])->name('barberUpdate');
});

Route::prefix('branch')->name('branch.')->group(function() {

    Route::get('/create', [BranchController::class, 'create'])->name('create');
    Route::post('/store', [BranchController::class, 'store'])->name('store');
    Route::get('/index',[BranchController::class, 'index'])->name('index');
    route::get('/edit/{branch}',[BranchController::class,'edit'])->name('edit');
    route::post('/update/{branch}', [BranchController::class,'update'])->name('update');

    Route::prefix('services')->name('services.')->group(function() {
        
        Route::get('/create/{branch}', [ServicesController::class,'create'])->name('create');
        Route::post('/store/{branch}', [ServicesController::class,'store'])->name('store');
        Route::get('/index/{branch}', [ServicesController::class,'index'])->name('index');
        Route::get('/edit/{service}', [ServicesController::class,'edit'])->name('edit');
        Route::post('/update/{service}', [ServicesController::class,'update'])->name('update');
        Route::get('/destroy/{service}', [ServicesController::class,'destroy'])->name('destroy');
        Route::get('/change-status/{service}', [ServicesController::class,'changeStatus'])->name('change-status');

    });
    Route::prefix('barber')->name('barber.')->group(function() {

        Route::get('/create/{branch}', [EmployeeController::class,'addBarber'])->name('create');
        Route::post('/store/{employee}', [EmployeeController::class,'store'])->name('store');
        Route::get('/destroy/{barber}', [EmployeeController::class,'destroy'])->name('destroy');
        
    });
});

Route::prefix('profile')->name('profile.')->group(function() {

   Route::get('/create', [ProfileController::class, 'create'])->name('create');
   Route::post('/store',[ProfileController::class,'store'])->name('store');
   Route::get('/index',[ProfileController::class,'index'])->name('index');

   Route::prefix('validation')->name('validation.')->group(function() {

        Route::get('/approve/{profile}', [ProfileController::class,'approveProfile'])->name('approve');
        Route::get('/disapprove/{profile}', [ProfileController::class,'disapproveProfile'])->name('disapprove');
        

   });

});

Route::prefix('appointment')->name('appointment.')->group(function() {

    Route::get('/index',[AppointmentController::class,'index'])->name('index');
    Route::get('/barber/{appointment_at}/{branch_id}', [AppointmentController::class, 'available_barber'])->name('barber');
    Route::get('/create', [AppointmentController::class, 'create'])->name('create');
    Route::post('/store',[AppointmentController::class,'store'])->name('store');
    Route::get('/show/{appointment}', [AppointmentController::class, 'show'])->name('show');
    Route::get('/approval/{appointment_id}/{status}/{message}', [AppointmentController::class, 'approval'])->name('approval');
    Route::get('/edit/{appointment}', [AppointmentController::class, 'appointmentEdit'])->name('edit');
    Route::post('/update',[AppointmentController::class,'appointmentUpdate'])->name('update');
   Route::get('/rebook/{appointment_id}/{appointment_at}/{branch_id}', [AppointmentController::class, 'rebooking_available_barber'])->name('rebook_barbers');

 });

Route::prefix('maintenance')->name('maintenance.')->group(function() {

    Route::get('/index',[MaintenanceController::class,'index'])->name('index');
    Route::post('/store/header',[MaintenanceController::class,'header'])->name('store.header');
    Route::post('/store/branch',[MaintenanceController::class,'branch'])->name('store.branch');
    Route::post('/store/service',[MaintenanceController::class,'service'])->name('store.service');
    Route::post('/store/about',[MaintenanceController::class,'about'])->name('store.about');
    Route::post('/store/contact',[MaintenanceController::class,'contact'])->name('store.contact');
    Route::post('/store/footer',[MaintenanceController::class,'footer'])->name('store.footer');
    Route::post('/store/announcement',[MaintenanceController::class,'announcement'])->name('store.announcement');

    Route::prefix('service')->name('service.')->group(function() {

        Route::post('store', [LandingPageServiceController::class, 'store'])->name('store');
        Route::put('update/{service}', [LandingPageServiceController::class, 'update'])->name('update');
        Route::get('destroy/{service}', [LandingPageServiceController::class, 'destroy'])->name('destroy');
    });
});


Route::prefix('contactmessages')->name('contactmessage.')->group(function() {

    Route::get('/index', [ContactMessageController::class,'index'])->name('index');
    Route::post('/store', [ContactMessageController::class,'store'])->name('store');
});

Route::delete('/contact-messages/{message}', [ContactMessageController::class, 'destroy'])->name('contact-messages.destroy');


Route::prefix('activity-logs')->name('activity-logs.')->group(function() {
    Route::match(['get', 'post'], '/index', [ActivityLogController::class, 'index'])->name('index');
});


Route::prefix('otp')->name('otp.')->group(function() {

    Route::post('/authenticate',[App\Http\Controllers\HomeController::class, 'otpAuthenticate'])->name('authenticate');

});

Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');

Route::prefix('notifications')->name('notifications.')->group(function() {
    Route::match(['get', 'post'], '/index', [NotificationController::class, 'index'])->name('index');
    
});

Route::put('/notifications/mark-all-as-read', 'App\Http\Controllers\NotificationController@markAllAsRead')->name('notifications.mark-all-as-read');


Route::get('/appointment/{appointment}', [AppointmentController::class, 'view'])->name('appointment.view');


// Route::get('markAsRead', function(){
//     auth()->user()->unreadNotifications->markAsRead();
//     return redirect()->back();
// })->name('markRead');

Route::put('markAsRead', function(){
    auth()->user()->unreadNotifications->markAsRead();
    return redirect()->back();
})->name('markRead');
 


Route::match(['get', 'post'], '/check-overlapping-appointment', 'App\Http\Controllers\AppointmentController@checkOverlappingAppointment');

Route::match(['get', 'post'], '/rebook-check-overlapping-appointment', 'App\Http\Controllers\AppointmentController@rebookCheckOverlappingAppointment');



Route::get('/chart', [AppointmentController::class, 'chartIndex'])->name('chart.index');










