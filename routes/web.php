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
use App\Http\Controllers\GuestSiteOtherInstitutionController;
use App\Http\Controllers\UDBStaffGuestSiteController;
use App\Http\Controllers\UDBTeacherGuestSiteController;
use App\Http\Controllers\viewEventLogController;
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

//Rutas relacionadas con el controlador de administrador (AdminController)
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
    route::delete('/destroyer',[AdminController::class,'destroyer'])->name('admin.destroyer');
});

//Rutas relacionadas con el controlador de eventos (EventController)
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

//Rutas relacionadas con el controlador de invitados (GuestSiteController)
Route::prefix('invitado')->group(function(){
    route::get('/index',[GuestSiteController::class,'guestSite'])->name('guestSite.index');
    route::post('/add',[GuestSiteController::class,'store'])->name('guestSite.add');
    route::get('/',[GuestSiteController::class,'site'])->name('guestSite.site');
    route::get('show/{id}', [GuestSiteController::class, 'show'])->name('guestSite.showInfo');
    Route::get('/miPerfil', [guestSiteController::class, 'miPerfil'])->name('guestSite.miPerfil');
    route::put('/updateInfor',[guestSiteController::class,'updateInfor'])->name('guestSite.updateInfor');
    route::get('/adquirir/entrada/{id}', [guestSiteController::class, 'purchaseTicketI'])->name('guestSite.ticketI');    
    route::get('/adquirir/entradas/{id}', [guestSiteController::class, 'purchaseTicketG'])->name('guestSite.ticketG');
    route::get('/entradas/adquiridas', [guestSiteController::class, 'purchasedTicket'])->name('guestSite.purchasedTicket');     
    route::post('/QR', [guestSiteController::class, 'addEntry'])->name('guestSite.addEntry');
    Route::post('/storeEntries', [guestSiteController::class, 'storeEntries'])->name('guestSite.storeEntries');
    Route::post('/deleteEntryI', [guestSiteController::class, 'deleteEntryI'])->name('guestSite.deleteEntryI');
    Route::post('/deleteEntryG', [guestSiteController::class, 'deleteEntryG'])->name('guestSite.deleteEntryG');
});
//Rutas relacionadas con el controlador de usuarios (usuarioController)
Route::prefix('user')->group(function(){
    route::get('/index',[usuarioController::class, 'index'])->name('user.index');
    route::get('/cambiarContraFormulario',[usuarioController::class,'formContra'])->name('users.formContra');
    route::put('/cambiarContra',[usuarioController::class, 'cambiarContra'])->name('user.cambiarContra');
    route::get('/propaganda',[usuarioController::class,'propagandaEvento'])->name('user.site');
    route::post('/user/send/{id}', [UsuarioController::class, 'send'])->name('user.send');
});

//Rutas relacionadas con el controlador de login (LoginController)
Route::post('/login',[LoginController::class, 'login'])->name('login');
Route::get('/loginView', [LoginController::class, 'showLogin'])->name('showLogin');
Route::post('/firsAdmin', [LoginController::class, 'storeFirstAdmin'])->name('storeFirstAdmin');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/recuperarView', [LoginController::class, 'recuperarView'])->name('recuperarView');
Route::post('/recuperarContra', [LoginController::class, 'recuperarContra'])->name('recuperarContra');


//Rutas relacionadas con el controlador de estudiantes (GuestStudentSiteController)
Route::get('/UDB', [GuestStudentSiteController::class, 'index'])->name('student.index');
Route::get('/invitados', [GuestStudentSiteController::class, 'guest'])->name('student.guest');

//Rutas relacionadas con el controlador de estudiantes UDB(UDBStudentGuestSiteController)
Route::prefix('estudiante/UDB')->group(function(){
    route::get('/',[UDBStudentGuestSiteController::class, 'studentUDB'])->name('UDBStudentGuestSite.index');
    route::post('/add',[UDBStudentGuestSiteController::class,'store'])->name('UDBStudentGuestSite.add');
    route::get('/index',[UDBStudentGuestSiteController::class,'site'])->name('UDBStudentGuestSite.site');
    route::get('show/{id}', [UDBStudentGuestSiteController::class, 'show'])->name('UDBStudentGuestSite.showInfo');
    Route::get('/miPerfil', [UDBStudentGuestSiteController::class, 'miPerfil'])->name('UDBStudentGuestSite.miPerfil');
    route::put('/updateInfor',[UDBStudentGuestSiteController::class,'updateInfor'])->name('UDBStudentGuestSite.updateInfor');
    route::get('/adquirir', [UDBStudentGuestSiteController::class, 'buyIndividualGroupTicket'])->name('UDBStudentGuestSite.ticketIG');
    route::get('/adquirir/entrada/{id}', [UDBStudentGuestSiteController::class, 'purchaseTicketI'])->name('UDBStudentGuestSite.ticketI');    
    route::get('/adquirir/entradas/{id}', [UDBStudentGuestSiteController::class, 'purchaseTicketG'])->name('UDBStudentGuestSite.ticketG');
    route::get('/entradas/adquiridas', [UDBStudentGuestSiteController::class, 'purchasedTicket'])->name('UDBStudentGuestSite.purchasedTicket');     
    route::post('/QR', [UDBStudentGuestSiteController::class, 'addEntry'])->name('UDBStudentGuestSite.addEntry');
    Route::post('/storeEntries', [UDBStudentGuestSiteController::class, 'storeEntries'])->name('UDBStudentGuestSite.storeEntries');
    Route::post('/deleteEntryI', [UDBStudentGuestSiteController::class, 'deleteEntryI'])->name('UDBStudentGuestSite.deleteEntryI');
    Route::post('/deleteEntryG', [UDBStudentGuestSiteController::class, 'deleteEntryG'])->name('UDBStudentGuestSite.deleteEntryG');
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

//Rutas relacionadas con el controlador de personal UDB (UDBStaffGuestSiteController)
Route::prefix('personal/UDB')->group(function(){
    route::get('/',[UDBStaffGuestSiteController::class, 'personalUDB'])->name('UDBStaffGuestSite.index');
    route::post('/add',[UDBStaffGuestSiteController::class,'store'])->name('UDBStaffGuestSite.add');
    route::get('/index',[UDBStaffGuestSiteController::class,'site'])->name('UDBStaffGuestSite.site');
    route::get('show/{id}', [UDBStaffGuestSiteController::class, 'show'])->name('UDBStaffGuestSite.showInfo');
    Route::get('/miPerfil', [UDBStaffGuestSiteController::class, 'miPerfil'])->name('UDBStaffGuestSite.miPerfil');
    route::put('/updateInfor',[UDBStaffGuestSiteController::class,'updateInfor'])->name('UDBStaffGuestSite.updateInfor');
    route::get('/adquirir', [UDBStaffGuestSiteController::class, 'buyIndividualGroupTicket'])->name('UDBStaffGuestSite.ticketIG');
    route::get('/adquirir/entrada/{id}', [UDBStaffGuestSiteController::class, 'purchaseTicketI'])->name('UDBStaffGuestSite.ticketI');    
    route::get('/adquirir/entradas/{id}', [UDBStaffGuestSiteController::class, 'purchaseTicketG'])->name('UDBStaffGuestSite.ticketG');
    route::get('/entradas/adquiridas', [UDBStaffGuestSiteController::class, 'purchasedTicket'])->name('UDBStaffGuestSite.purchasedTicket');     
    route::post('/QR', [UDBStaffGuestSiteController::class, 'addEntry'])->name('UDBStaffGuestSite.addEntry');
    Route::post('/storeEntries', [UDBStaffGuestSiteController::class, 'storeEntries'])->name('UDBStaffGuestSite.storeEntries');
    Route::post('/deleteEntryI', [UDBStaffGuestSiteController::class, 'deleteEntryI'])->name('deleteEntryI');
    Route::post('/deleteEntryG', [UDBStaffGuestSiteController::class, 'deleteEntryG'])->name('deleteEntryG');
    });


//Rutas relacionadas con el controlador de estudiante otra institucion  (GuestSiteOtherInstitutionController)
Route::prefix('invitado/estudiante')->group(function(){
    route::get('/',[GuestSiteOtherInstitutionController::class, 'student'])->name('StudentGuestSite.index');
    route::post('/add',[GuestSiteOtherInstitutionController::class,'store'])->name('StudentGuestSite.add');
    route::get('/index',[GuestSiteOtherInstitutionController::class,'site'])->name('StudentGuestSite.site');
    route::get('show/{id}', [GuestSiteOtherInstitutionController::class, 'show'])->name('StudentGuestSite.showInfo');
    Route::get('/miPerfil', [GuestSiteOtherInstitutionController::class, 'miPerfil'])->name('StudentGuestSite.miPerfil');
    route::put('/updateInfor',[GuestSiteOtherInstitutionController::class,'updateInfor'])->name('StudentGuestSite.updateInfor');
    route::get('/adquirir', [GuestSiteOtherInstitutionController::class, 'buyIndividualGroupTicket'])->name('StudentGuestSite.ticketIG');
    route::get('/adquirir/entrada/{id}', [GuestSiteOtherInstitutionController::class, 'purchaseTicketI'])->name('StudentGuestSite.ticketI');    
    route::get('/adquirir/entradas/{id}', [GuestSiteOtherInstitutionController::class, 'purchaseTicketG'])->name('StudentGuestSite.ticketG');
    route::get('/entradas/adquiridas', [GuestSiteOtherInstitutionController::class, 'purchasedTicket'])->name('StudentGuestSite.purchasedTicket');     
    route::post('/QR', [GuestSiteOtherInstitutionController::class, 'addEntry'])->name('StudentGuestSite.addEntry');
    Route::post('/storeEntries', [GuestSiteOtherInstitutionController::class, 'storeEntries'])->name('StudentGuestSite.storeEntries');
    Route::post('/deleteEntryI', [GuestSiteOtherInstitutionController::class, 'deleteEntryI'])->name('StudentGuestSite.deleteEntryI');
    Route::post('/deleteEntryG', [GuestSiteOtherInstitutionController::class, 'deleteEntryG'])->name('StudentGuestSite.deleteEntryG');});

// Rutas relacionadas al controlador para ver el registro de entradas adquiridas (viewEventLogController)
Route::get('/entry/{id}', [viewEventLogController::class, 'show'])->name('viewEventLog.entry');
Route::put('/entry/confirm/{idEntrada}', [viewEventLogController::class, 'confirmAsistencia'])->name('confirmAsistencia');
Route::put('/entry/confirmG/{idEntrada}', [viewEventLogController::class, 'confirmAsistenciaG'])->name('confirmAsistenciaG');
Route::get('/registro', [viewEventLogController::class, 'viewAttendanceRecordEntertainmentArea'])->name('viewEventLog.viewAttendanceRecordEntertainmentArea');
Route::get('/registros/UDB', [viewEventLogController::class, 'viewAttendanceRecordUDB'])->name('viewEventLog.viewAttendanceRecordUDB');
Route::get('/attendance/records', [viewEventLogController::class, 'viewAttendanceRecordEntertainmentArea'])->name('attendance.records');
Route::get('/entry/edit/{idEntrada}', [viewEventLogController::class, 'editCantidad'])->name('editCantidad');
route::get('/adquirir/entradas/{id}', [viewEventLogController::class, 'purchaseTicketG'])->name('viewEventLog.ticketG');
Route::put('/entry/updateCantidad', [viewEventLogController::class, 'updateCantidad'])->name('updateCantidad');
Route::post('/entry/save', [viewEventLogController::class, 'storeEntries'])->name('storeEntries');
