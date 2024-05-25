<?php
use App\Http\Controllers\InvitadoController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\GuestStudentSiteController;
use App\Http\Controllers\UDBStudentGuestSiteController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\GuestSiteController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/',[LoginController::class, 'welcome'])->name('welcome');

Route::prefix('admin')->group(function(){
    route::get('/index',[AdminController::class, 'index'])->name('admin.index');
    route::get('/create',[AdminController::class, 'create'])->name('admin.create');
    route::post('/add',[AdminController::class, 'store'])->name('admin.add');
    route::get('/show/{id}',[AdminController::class, 'show'])->name('admin.adminInfo');
    route::get('/edit/{id}',[AdminController::class, 'edit'])->name('admin.edit');
    route::put('/update/{id}',[AdminController::class, 'update'])->name ('admin.update');
    route::delete('/delete',[AdminController::class,'destroy'])->name('admin.delete');
    route::get('/restoreView',[AdminController::class,'restoreView'])->name('admin.restoreView');
    route::put('/restore',[AdminController::class, 'restore'])->name('admin.restore');

});

Route::prefix('event')->group(function(){
    route::get('/index',[EventController::class,'index'])->name('events.index');
    route::get('create',[EventController::class,'create'])->name('events.create');
    route::post('add', [EventController::class, 'store'])->name(('events.add'));
    route::get('show/{id}', [EventController::class, 'show'])->name('events.showInfo');
    route::get('edit/{id}', [EventController::class, 'edit'])->name('events.edit');
    route::put('/update/{id}',[EventController::class, 'update'])->name ('events.update');
    route::delete('/delete',[EventController::class,'destroy'])->name('events.delete');
    route::get('/restoreView',[EventController::class,'restoreView'])->name('event.restoreView');
    route::put('/restore',[EventController::class, 'restore'])->name('event.restore');
    route::delete('/destroyer',[EventController::class,'destroyer'])->name('events.destroyer');
});

Route::prefix('invitado')->group(function(){
    route::get('/index',[GuestSiteController::class,'guestSite'])->name('guestSite.index');
    route::post('/add',[GuestSiteController::class,'store'])->name('guestSite.add');
    route::get('/',[GuestSiteController::class,'site'])->name('guestSite.site');
    route::get('show/{id}', [GuestSiteController::class, 'show'])->name('guestSite.showInfo');
    Route::get('/miPerfil', [guestSiteController::class, 'miPerfil'])->name('guestSite.miPerfil');
    route::put('/updateInfor',[guestSiteController::class,'updateInfor'])->name('guestSite.updateInfor');
});


Route::prefix('user')->group(function(){
    route::get('/index',[usuarioController::class, 'index'])->name('user.index');
});

//Rutas relacionadas con el controlador de login (LoginController)
Route::post('/login',[LoginController::class, 'login'])->name('login');
Route::get('/loginView', [LoginController::class, 'showLogin'])->name('showLogin');
Route::post('/firsAdmin', [LoginController::class, 'storeFirstAdmin'])->name('storeFirstAdmin');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
//Route::get('/recuperarView', [LoginController::class, 'recuperarView'])->name('recuperarView');
//Route::post('/recuperarContra', [LoginController::class, 'recuperarContra'])->name('recuperarContra');

//Rutas relacionadas con el controlador de estudiantes (GuestStudentSiteController)
Route::get('/estudiantes', [GuestStudentSiteController::class, 'index'])->name('student.index');

//Rutas relacionadas con el controlador de estudiantes UDB(UDBStudentGuestSiteController)
Route::prefix('estudiante/UDB')->group(function(){
    route::get('/',[UDBStudentGuestSiteController::class, 'studentUDB'])->name('UDBStudentGuestSite.index');
    route::post('/add',[UDBStudentGuestSiteController::class,'store'])->name('UDBStudentGuestSite.add');
    route::get('/index',[UDBStudentGuestSiteController::class,'site'])->name('UDBStudentGuestSite.site');
    route::get('show/{id}', [UDBStudentGuestSiteController::class, 'show'])->name('UDBStudentGuestSite.showInfo');
    Route::get('/miPerfil', [UDBStudentGuestSiteController::class, 'miPerfil'])->name('UDBStudentGuestSite.miPerfil');
    route::put('/updateInfor',[UDBStudentGuestSiteController::class,'updateInfor'])->name('UDBStudentGuestSite.updateInfor');
});

//Rutas relacionadas con el controlador de areas (AreaController)
Route::prefix('area')->group(function(){
    route::get('/index',[AreaController::class, 'index'])->name('area.index');
    route::post('/add',[AreaController::class, 'store'])->name('area.store');
    route::get('/create',[AreaController::class, 'create'])->name('area.create');
    route::delete('/delete',[AreaController::class,'destroy'])->name('area.delete');
    route::get('/restoreView',[AreaController::class,'restoreView'])->name('area.restoreView');
    route::put('/restore',[AreaController::class, 'restore'])->name('area.restore');
});

