<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PusherController;
use App\Http\Controllers\RequestController;
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

//Main Route
Route::get('/', function () {
    $responseChat = Http::withOptions(['verify' => false])->get('https://asia-south1.gcp.data.mongodb-api.com/app/application-0-xighs/endpoint/getAllChat');
    $jsonChat = $responseChat->json();

    $responseProduct = Http::withOptions(['verify' => false])->get('https://asia-south1.gcp.data.mongodb-api.com/app/application-0-xighs/endpoint/getAllProduct');
    $jsonProduct = $responseProduct->json();

    if($responseChat->successful() && $responseProduct->successful()) {
        return view('index', ['chats' => $jsonChat, 'products' => $jsonProduct]);
    } else {
        return redirect('/');
    }
    
});

//Analyze Route
Route::get('/analyze', function () {
    $responseChat = Http::withOptions(['verify' => false])->get('https://asia-south1.gcp.data.mongodb-api.com/app/application-0-xighs/endpoint/getAllChat');
    $jsonChat = $responseChat->json();

    if($responseChat->successful()) {
        return view('analyze', ['chats' => $jsonChat]);
    } else {
        return redirect('/analyze');
    }
});

//About Route
Route::get('/about', function () {
    $responseChat = Http::withOptions(['verify' => false])->get('https://asia-south1.gcp.data.mongodb-api.com/app/application-0-xighs/endpoint/getAllChat');
    $jsonChat = $responseChat->json();

    if($responseChat->successful()) {
        return view('about', ['chats' => $jsonChat]);
    } else {
        return redirect('/about');
    }
});

//Learn Route
Route::get('/learn', function () {
    $responseChat = Http::withOptions(['verify' => false])->get('https://asia-south1.gcp.data.mongodb-api.com/app/application-0-xighs/endpoint/getAllChat');
    $jsonChat = $responseChat->json();

    if($responseChat->successful()) {
        return view('learn', ['chats' => $jsonChat]);
    } else {
        return redirect('/learn');
    }

});


//Login Route
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

//Signup Route
Route::get('/signup', [AuthController::class,'showSignupForm'])->name('signup');
Route::post('/signup', [AuthController::class,'signup'])->name('signup');

//Logout Route
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

//Forget Password Route
Route::get('/forget', [AuthController::class, 'showForgetForm']);
Route::post('/sendmail', [MailController::class, 'sendMail']);
Route::get('/resetpassword/{id}', [AuthController::class, 'showResetForm'])->name('reset.show');
Route::post('/changepassword', [AuthController::class, 'changePassword']);

//Profile Route
Route::get('/profile', [ProfileController::class,'profile'])->name('');
Route::get('/editprofile', [ProfileController::class,'editprofile'])->name('editprofile');
Route::post('/updateprofile', [ProfileController::class,'updateprofile'])->name('updateprofile');

//Product Route
Route::get('/product', [ProductController::class,'loadProduct']);
Route::get('/product/{productId}', [ProductController::class, 'showProduct'])->name('product.show');

//requestForm
Route::get('/requestform', [RequestController::class,'showRequestForm']);
Route::post('/makerequest', [RequestController::class,'makerequest'])->name('makerequest');

//Dashboard Admin Route
Route::get('/dashboard', [DashboardController::class,'loadDashboard']);

Route::get('/productdashboard', [DashboardController::class,'loadProductDashboard']);

Route::get('/productdashboard/add/', [DashboardController::class, 'loadAddProductDashboard']);
Route::post('/addproduct', [DashboardController::class, 'addproduct'])->name('addproduct');

Route::get('/productdashboard/edit/{productId}', [DashboardController::class, 'loadEditProductDashboard']);
Route::post('/updateproduct', [DashboardController::class, 'updateProduct'])->name('updateproduct');

Route::get('/productdashboard/delete/{productId}', [DashboardController::class, 'deleteproduct']);

Route::get('/productrequest', [DashboardController::class,'loadRequestDashboard']);
Route::get('/setnotification/{requestId}/{sellerId}/{productId}/{action}', [DashboardController::class,'setNotification']);

Route::get('/deleteallchat', [DashboardController::class, 'deleteAllChat']);

//Pusher Route
Route::post('/broadcast', [PusherController::class,'broadcast']);
Route::post('/receive', [PusherController::class,'receive']);




