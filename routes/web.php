<?php

use App\Http\Controllers\ChartController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppsController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UtilityController;
use App\Http\Controllers\WidgetsController;
use App\Http\Controllers\SetLocaleController;
use App\Http\Controllers\ComponentsController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\DatabaseBackupController;
use App\Http\Controllers\GeneralSettingController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\DoctorSpecialistController;
use App\Http\Controllers\NurseController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\LobbyController;
use App\Http\Controllers\PlasmaController;
use App\Http\Controllers\PlasmaSpecialistController;
use App\Http\Controllers\MarketingController;
use App\Http\Controllers\PlasmaAioController;
use App\Http\Controllers\MasterDokterController;
use App\Http\Controllers\MasterDriverController;
use App\Http\Controllers\MasterNodController;
use App\Http\Controllers\MasterNurseController;
use App\Http\Controllers\MasterPonekController;
use App\Http\Controllers\MasterShiftController;
use App\Http\Controllers\NodController;
use App\Http\Controllers\PonekController;
use App\Http\Controllers\ScheduleDokterController;

require __DIR__ . '/auth.php';

Route::get('/', function () {
    return to_route('login');
});
// Plasma
Route::get('plasma', [PlasmaController::class, 'index'])->name('plasma');
Route::get('plasma2', [PlasmaAioController::class, 'index'])->name('plasma2');
Route::get('lobby', [LobbyController::class, 'index'])->name('lobby');
Route::group(['middleware' => ['auth', 'verified']], function () {
    // Dashboards
    Route::get('dashboard', [HomeController::class, 'index'])->name('dashboard.index');
    // Locale
    Route::get('setlocale/{locale}', SetLocaleController::class)->name('setlocale');

    // User
    Route::resource('users', UserController::class);
    // Permission
    Route::resource('permissions', PermissionController::class)->except(['show']);
    // Roles
    Route::resource('roles', RoleController::class);
    // Profiles
    Route::resource('profiles', ProfileController::class)->only(['index', 'update'])->parameter('profiles', 'user');
    // Env
    Route::singleton('general-settings', GeneralSettingController::class);
    Route::post('general-settings-logo', [GeneralSettingController::class, 'logoUpdate'])->name('general-settings.logo');

    // Database Backup
    Route::resource('database-backups', DatabaseBackupController::class);
    Route::get('database-backups-download/{fileName}', [DatabaseBackupController::class, 'databaseBackupDownload'])->name('database-backups.download');

    // Doctor
    Route::get('doctors/download-template', [DoctorController::class, 'downloadTemplate'])->name('doctors.downloadTemplate');
    Route::resource('doctors', DoctorController::class);
    Route::match(['get', 'post'], 'doctors', [DoctorController::class, 'index'])->name('doctors.index');
    Route::post('/doctors/upload-excel', [DoctorController::class, 'storeExcel'])->name('doctors.uploadExcel');
    Route::post('/doctors/upload-json', [DoctorController::class, 'storeJson'])->name('doctors.storeJson');
    Route::get('/doctors/create', [DoctorController::class, 'create'])->name('doctors.create');

    // Master Shift
    Route::resource('shift', MasterShiftController::class);

    // Master Doctor
    Route::resource('master-dokters', MasterDokterController::class);
    Route::post('/master-dokters/upload-json', [MasterDokterController::class, 'storeJson'])->name('master-dokters.storeJson');

    // Master Nod
    Route::resource('master-nod', MasterNodController::class);
    Route::post('/master-nod/upload-excel', [MasterNodController::class, 'storeExcel'])->name('master-nod.uploadExcel');

    // Master Nurse
    Route::resource('master-nurses', MasterNurseController::class);
    Route::post('/master-nurses/upload-excel', [MasterNurseController::class, 'storeExcel'])->name('master-nurses.uploadExcel');

    Route::resource('master-ponek', MasterPonekController::class);
    Route::post('/master-ponek/upload-json', [MasterPonekController::class, 'storeExcel'])->name('master-ponek.uploadExcel');

    // Master Driver
    Route::resource('master-driver', MasterDriverController::class);
    Route::post('/master-driver/upload-excel', [MasterDriverController::class, 'storeExcel'])->name('master-driver.uploadExcel');

    // Schedule Doctor
    Route::resource('schedule-dokters', ScheduleDokterController::class);
    Route::match(['get', 'post'], 'schedule-dokters', [ScheduleDokterController::class, 'index'])->name('schedule-dokters.index');

    // Doctor Specialist
    Route::get('doctorSpecialist/download-template', [DoctorSpecialistController::class, 'downloadTemplate'])->name('doctorSpecialist.downloadTemplate');
    Route::resource('doctorSpecialist', DoctorSpecialistController::class);
    Route::match(['get', 'post'], 'doctorSpecialist', [DoctorSpecialistController::class, 'index'])->name('doctorSpecialist.index');
    Route::post('doctorSpecialist/upload-excel', [DoctorSpecialistController::class, 'storeExcel'])->name('doctorSpecialist.uploadExcel');

    // Nod
    Route::get('nod/download-template', [NodController::class, 'downloadTemplate'])->name('nod.downloadTemplate');
    Route::resource('nod', NodController::class);
    Route::match(['get', 'post'], 'nod', [NodController::class, 'index'])->name('nod.index');
    Route::post('/nod/upload-excel', [NodController::class, 'storeExcel'])->name('nod.uploadExcel');

    // Nurse
    Route::get('nurses/download-template', [NurseController::class, 'downloadTemplate'])->name('nurses.downloadTemplate');
    Route::resource('nurses', NurseController::class);
    Route::post('/nurses/upload-excel', [NurseController::class, 'storeExcel'])->name('nurses.uploadExcel');
    Route::match(['get', 'post'], 'nurses', [NurseController::class, 'index'])->name('nurses.index');

    // Schedule
    Route::resource('schedules', ScheduleController::class);
    // Route::get('plasmaSpecialist', [ScheduleController::class, 'plasmaView'])->name('plasmaSpecialist');
    Route::get('/schedules/create', [ScheduleController::class, 'create'])->name('schedules.create');
    Route::post('/schedules/upload-excel', [ScheduleController::class, 'storeExcel'])->name('schedules.uploadExcel');


    // Driver
    Route::get('drivers/download-template', [DriverController::class, 'downloadTemplate'])->name('drivers.downloadTemplate');
    Route::resource('drivers', DriverController::class);
    Route::match(['get', 'post'], 'drivers', [DriverController::class, 'index'])->name('drivers.index');
    Route::post('/drivers/upload-excel', [DriverController::class, 'storeExcel'])->name('drivers.uploadExcel');

    //Marketing
    Route::resource('marketing', MarketingController::class);

    // Ponek
    Route::get('ponek/download-template', [PonekController::class, 'downloadTemplate'])->name('ponek.downloadTemplate');
    Route::resource('ponek', PonekController::class);
    Route::match(['get', 'post'], 'ponek', [PonekController::class, 'index'])->name('ponek.index');
    Route::post('/ponek/upload-excel', [PonekController::class, 'storeExcel'])->name('ponek.uploadExcel');

    //Lobby
    Route::resource('lobby', LobbyController::class);
});
