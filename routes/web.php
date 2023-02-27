<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\DataController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\UserController;
use Vizir\KeycloakWebGuard\Controllers\AuthController as Keycloak;

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


Route::get('/keycloak/redirect', [AuthController::class, 'redirect']);
Route::get('/keycloak/redirect-logout', [AuthController::class, 'redirectLogout']);
Route::post('signin', [AuthController::class, 'login']);
Route::get('signout', [AuthController::class, 'keluar']);
Route::get('login', [AuthController::class, 'showLoginPage'])->name('login');
//Route::get('login', [Keycloak::class, 'login'])->name('login');
// Route::get('logout', [Keycloak::class, 'logout'])->name('logout');
//Route::get('callback', [Keycloak::class, 'callback'])->name('keycloak.callback');
Route::get('layanan/{id}', [DataController::class, 'showDetailLayanan']);
Route::get('template', function () {
    return view('template.form_akses_internal', ['name' => 'James']);
});


Route::group(['middleware' => 'checkKeycloak'], function () {
    Route::get('/error', [PageController::class, 'error']);
    Route::get('/profil', [PageController::class, 'profil']);
    Route::get('/pemberitahuan', [PageController::class, 'pemberitahuan']);
    Route::post('/mark-read', [PageController::class, 'markRead']); 
    Route::get('/request-list', [PageController::class, 'requestList']); 
    Route::get('/bidang/{id}', [PageController::class, 'showLayanan']);

    
    //Layanan
    Route::get('/', [DataController::class, 'home'])->middleware('checkHome');
    Route::get('layanan/{id}', [DataController::class, 'showDetailLayanan']);

    Route::get('admin/dashboard', [AdminController::class, 'dashboard'])->middleware('checkRole:admin');
    Route::get('admin/request', [AdminController::class, 'showRequestList'])->middleware('checkRole:admin');
    Route::get('admin/request/detail/{id}', [AdminController::class, 'requestDetail'])->middleware('checkRole:admin');
    Route::get('request/detail/{id}', [RequestController::class, 'requestDetail'])->middleware('checkRole:admin,kasi,kabid,kapus,pelaksana,pemohon');


    Route::post('admin/request/update', [AdminController::class, 'updateRequest'])->middleware('checkRole:admin');
    Route::get('admin/layanan', [AdminController::class, 'layanan'])->middleware('checkRole:admin');
    Route::get('admin/layanan/tambah', [AdminController::class, 'formLayanan'])->middleware('checkRole:admin');
    Route::get('admin/layanan/edit/{id}', [AdminController::class, 'editLayanan'])->middleware('checkRole:admin');
    Route::post('admin/tambah-layanan', [AdminController::class, 'addLayanan'])->middleware('checkRole:admin');
    Route::post('tambah-layanan', [AdminController::class, 'tambahLayanan'])->middleware('checkRole:admin');
    Route::post('update-layanan', [AdminController::class, 'updateLayanan'])->middleware('checkRole:admin');
    Route::post('tambah-field', [AdminController::class, 'addField'])->middleware('checkRole:admin');
    Route::get('hapus-field/{id}', [AdminController::class, 'deleteField']);
    Route::post('upload-image', [AdminController::class, 'uploadImage'])->name('upload.image');
    Route::get('admin/approver', [AdminController::class, 'approver'])->middleware('checkRole:admin');
    Route::post('tambah-approver', [AdminController::class, 'tambahApprover'])->middleware('checkRole:admin');
    Route::post('admin/input-data-approver', [AdminController::class, 'inputApprover'])->middleware('checkRole:admin');
    Route::post('admin/update-data-approver', [AdminController::class, 'updateApprover'])->middleware('checkRole:admin');
    Route::post('admin/delete-data-approver', [AdminController::class, 'deleteApprover'])->middleware('checkRole:admin');

    //request
    Route::get('layanan/request/{id}', [RequestController::class, 'requestLayanan'])->middleware('checkRole:pemohon');
    Route::post('tambah-user-email', [RequestController::class, 'tambahEmailUser'])->middleware('checkRole:pelaksana,admin');
    Route::post('tambah-request', [RequestController::class, 'addRequest'])->middleware('checkRole:pemohon');
    Route::post('tambah-server', [RequestController::class, 'tambahServer'])->middleware('checkRole:pemohon');
    Route::post('tambah-va', [RequestController::class, 'tambahVA'])->middleware('checkRole:pemohon');
    Route::post('tambah-email', [RequestController::class, 'tambahEmail'])->middleware('checkRole:pemohon');
    Route::post('tambah-akses', [RequestController::class, 'tambahAkses'])->middleware('checkRole:pemohon');
    Route::post('tambah-jaringan', [RequestController::class, 'tambahJaringan'])->middleware('checkRole:pemohon');
    Route::post('tambah-keamanan-siber', [RequestController::class, 'tambahKeamananSiber'])->middleware('checkRole:pemohon');
    Route::post('update-request', [RequestController::class, 'updateRequest'])->middleware('checkRole:pemohon');
    Route::get('my-request', [RequestController::class, 'showMyRequest'])->middleware('checkRole:pemohon');
    Route::get('my-request/detail/{id}', [RequestController::class, 'detailRequest'])->middleware('checkRole:pemohon');
    Route::post('tutup-request', [RequestController::class, 'tutupRequest'])->middleware('checkRole:pemohon');
    Route::post('buka-request', [RequestController::class, 'bukaRequest'])->middleware('checkRole:pemohon');
    Route::post('setujui-request', [RequestController::class, 'setujuiRequest'])->middleware('checkRole:admin,kasi,pelaksana');
    Route::post('tolak-request', [RequestController::class, 'tolakRequest'])->middleware('checkRole:admin,kasi,pelaksana');

    //catatan
    Route::post('tambah-catatan', [RequestController::class, 'tambahCatatan'])->middleware('checkRole:pemohon,customerservice,pelaksana,admin');
    Route::post('tambah-disposisi', [RequestController::class, 'tambahDisposisi'])->middleware('checkRole:customerservice,pelaksana,kasi,kabid,kapus,admin');

    //user
    Route::get('admin/users', [UserController::class, 'index'])->middleware('checkRole:admin');
    Route::post('admin/users/tambah', [UserController::class, 'tambahUser'])->middleware('checkRole:admin');
    Route::post('admin/users/update', [UserController::class, 'updateUser'])->middleware('checkRole:admin');

    //cs
    Route::get('cs/dashboard', [PageController::class, 'dashboard_cs'])->middleware('checkRole:customerservice');
    Route::get('cs/request', [RequestController::class, 'showRequestList'])->middleware('checkRole:customerservice');
    Route::post('/request/ubah-status', [RequestController::class, 'ubahStatusRequest'])->middleware('checkRole:pelaksana,admin');
    Route::get('cs/request-saya', [RequestController::class, 'showRequestAssignToMe'])->middleware('checkRole:customerservice');

    //kasi
    Route::get('kasi/dashboard', [PageController::class, 'dashboard_kasi'])->middleware('checkRole:kasi');
    Route::get('kasi/request', [RequestController::class, 'showRequestList'])->middleware('checkRole:kasi');
    Route::get('kasi/request-saya', [RequestController::class, 'showRequestAssignToMe'])->middleware('checkRole:kasi');

    //kabid
    Route::get('kabid/dashboard', [PageController::class, 'dashboard_kabid'])->middleware('checkRole:kabid');
    Route::get('kabid/request', [RequestController::class, 'showRequestList'])->middleware('checkRole:kabid');
    Route::get('kabid/request-saya', [RequestController::class, 'showRequestAssignToMe'])->middleware('checkRole:kabid');

    //kapus
    Route::get('kapus/dashboard', [PageController::class, 'dashboard_kapus'])->middleware('checkRole:kapus');
    Route::get('kapus/request', [RequestController::class, 'showRequestList'])->middleware('checkRole:kapus');
    Route::get('kapus/request-saya', [RequestController::class, 'showRequestAssignToMe'])->middleware('checkRole:kapus');

    //pelaksana
    Route::get('pelaksana/dashboard', [PageController::class, 'dashboard_pelaksana'])->middleware('checkRole:pelaksana');
    Route::get('pelaksana/request', [RequestController::class, 'showRequestList'])->middleware('checkRole:pelaksana');
    Route::get('pelaksana/request-saya', [RequestController::class, 'showRequestAssignToMe'])->middleware('checkRole:pelaksana');

    Route::get('request', [RequestController::class, 'showRequestList'])->middleware('checkRole:admin');
    Route::post('tugaskan-request', [RequestController::class, 'reassignRequest'])->middleware('checkRole:admin');
    Route::get('tunggakan-saya', [RequestController::class, 'showRequestAssignToMe'])->middleware('checkRole:admin');
});

