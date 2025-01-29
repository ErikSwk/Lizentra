<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminPanel\AdminController;
use App\Http\Controllers\UserPanel\UserController;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Controllers\ComputerController;
use App\Http\Controllers\LizenzController;
use App\Http\Controllers\UserVerwaltungsController;
use App\Http\Controllers\SekretariatController;

use App\Http\Controllers\LizenzenControllerNeu;
use App\Http\Controllers\AlleLizenzenController;
use App\Http\Controllers\ComputerControllerNeu;

Route::get('/admin', [AdminController::class, 'index'])->name('admin');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/', [HomeController::class, 'index'])
        ->name('home');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

//Verifizierung
/* Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/approval/{id}', [HomeController::class, 'approval'])->name('approval');

    Route::get('user/dashboard/{id}', [UserController::class, 'index'])->name('user.dashboard');
}); */




/* Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
}); */

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/computer/{id}', [UserController::class, 'index'])->name('admin.dashboard.computer'); // Show Button der Sekreteriate
});

//Route::middleware(['auth', 'role:user'])->group(function () {
//    Route::get('user/dashboard/{id}', [UserController::class, 'index'])->name('user.dashboard');
//});

//Computer-Routen
Route::post('/store/{id}', [ComputerController::class, 'store'])->name('store');
Route::get('/getall/{id}', [ComputerController::class, 'getall'])->name('getall');
Route::get('/employee/{id}/edit', [ComputerController::class, 'edit'])->name('edit'); //anderes id hier gemeint,d as von computer und nicht das der sekreteriate
Route::post('/employee/update', [ComputerController::class, 'update'])->name('update');
Route::delete('/employee/delete/{id}', [ComputerController::class, 'delete'])->name('delete');

Route::get('/Computer/{id}', [ComputerController::class, 'view'])->name('viewComSek');

//Alle Computer
Route::get('/viewAlleComputer', [ComputerController::class, 'viewAlleComputer'])->name('viewAlleComputer');
Route::get('/getAlleComputer', [ComputerController::class, 'getAlleComputer'])->name('getAlleComputer');
Route::post('/storeBeiAlleComputer', [ComputerController::class, 'storeBeiAlleComputer'])->name('storeBeiAlleComputer');

// Lizenz-Routen
Route::get('/licenses', [LizenzController::class, 'getAll'])->name('licenses.getall');
Route::post('/licenses/{sek_id}/{PCID}/store', [LizenzController::class, 'store'])->name('licenses.store');
Route::post('/licenses/{sek_id}/{PCID}/exStore', [LizenzController::class, 'exStore'])->name('licenses.ex.store');

Route::get('/licenses/{LizenzID}/edit', [LizenzController::class, 'edit'])->name('licenses.edit'); //hier wieder Primär Schlüssel gemeint


Route::post('/licenses/update', [LizenzController::class, 'update'])->name('licenses.update'); // hier ist mit LizenzID nicht die LizenznID sonder die id als prim SChlüssel gemeint
Route::delete('/licenses/{LizenzID}/{PCID}/delete', [LizenzController::class, 'delete'])->name('licenses.delete');

Route::get('/licenses/rechnung/view/{LizenzID}', [LizenzController::class, 'viewRechnung'])->name('licenses.rechung.view'); //hier ebenfalls prim shclüssel gemient



// Lizenz-Verknüpfungen mit Computern
Route::get('/licenses/view/{sek_id}/{PCID}', [LizenzController::class, 'viewByPC'])->name('licenses.viewByPC');
Route::get('/licenses/pc/{PCID}', [LizenzController::class, 'getByPC'])->name('licenses.getByPC');

// Route, um alle User zu laden (Read)
Route::get('/User', [UserVerwaltungsController::class, 'getAll'])->name('getAllUser');

//Alle zum Freischalten abrufen
Route::get('/User/freischalten/abrufen', [UserVerwaltungsController::class, 'getAllUserZumFreischalten'])->name('getAllUserZumFreischalten');

Route::post('/User/freischalten', [UserVerwaltungsController::class, 'freischalten'])->name('freischaltenUser');

// Route, um ein neues User zu speichern (Create)
Route::post('/User/store', [UserVerwaltungsController::class, 'store'])->name('storeUser');

// Route, um ein User zu aktualisieren (Update)
Route::post('/User/update', [UserVerwaltungsController::class, 'update'])->name('updateUser');

// Route, um ein User zu löschen (Delete)
Route::delete('/User/delete', [UserVerwaltungsController::class, 'destroy'])->name('deleteUser');


// Neu
Route::get('/lizenzen/{id}', [LizenzenControllerNeu::class, 'view'])->name('viewLizenzen');
Route::get('/lizenzen/get/{id}', [LizenzenControllerNeu::class, 'get'])->name('getLizenzen');

Route::post('/lizenzen/add/{id}', [LizenzenControllerNeu::class, 'add'])->name('addLizenzen');

Route::post('/lizenzen/update', [LizenzenControllerNeu::class, 'update'])->name('updateLizenzen');

Route::delete('/lizenzen/delete/{Lizenzschluessel}', [LizenzenControllerNeu::class, 'delete'])->name('deleteLizenzen');

Route::get('/lizenzen/rechnung/{Lizenzschluessel}', [LizenzenControllerNeu::class, 'viewRechnung'])->name('viewRechnung');


// Computer einer Lizenz
Route::get('/computer_einer_lizenz/{sek_id}/{Lizenzschluessel}', [ComputerControllerNeu::class, 'view'])->name('viewComputerEinerLizenz');
Route::get('/getComputerLizenz/{Lizenzschluessel}', [ComputerControllerNeu::class, 'get'])->name('getComputerEinerLizenz');
Route::post('/entfComputerLizenz/{PCID}/{Lizenzschluessel}', [ComputerControllerNeu::class, 'entfernen'])->name('entfernenComputerEinerLizenz');


//Sekretariat
Route::get('/Sekretariat', [SekretariatController::class, 'getAll'])->name('getAllSekretariate');
Route::post('/Sekretariat/store', [SekretariatController::class, 'store'])->name('storeSekretariat');
Route::post('/Sekretariat/update', [SekretariatController::class, 'update'])->name('updateSekretariat');
Route::delete('/Sekretariat/delete', [SekretariatController::class, 'destroy'])->name('deleteSekretariat');
Route::get('/viewAlleSekretariate', [SekretariatController::class, 'viewAlleSekretariate'])->name('viewAlleSekretariate');

//Alle Lizenzen
Route::get('/alleLizenzen', [AlleLizenzenController::class, 'view'])->name('viewAlleLizenzen');
Route::get('/getAlleLizenzen', [AlleLizenzenController::class, 'get'])->name('getAlleLizenzen');