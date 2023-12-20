<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DonatorController;
use App\Http\Controllers\CarouselController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\TransactionController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index')->middleware(['auth', 'verified']);

Route::get('donations', [DonationController::class, 'index'])->name('donations.index')->middleware(['auth', 'verified']);
Route::post('donations/store', [DonationController::class, 'store'])->name('donations.store')->middleware('auth', 'verified');
Route::get('donations/{id}/edit', [DonationController::class, 'edit'])->name('donations.edit')->middleware('auth', 'verified');
Route::put('donations/update/{id}', [DonationController::class, 'update'])->name('donations.update')->middleware('auth', 'verified');
Route::delete('donations/delete/{id}', [DonationController::class, 'destroy'])->name('donations.destroy')->middleware('auth', 'verified');
Route::get('transactions', [TransactionController::class, 'index'])->name('transactions.index')->middleware(['auth', 'verified']);
Route::get('donators', [DonatorController::class, 'index'])->name('donator.index')->middleware(['auth', 'verified']);
Route::get('donation/{id}/donate', [TransactionController::class, 'donate'])->name('donation.donate')->middleware(['auth', 'verified']);
Route::post('donation/checkout/{id}', [TransactionController::class, 'checkout'])->name('donation.checkout')->middleware(['auth', 'verified']);
Route::get('donation/getPayment/{transaction_id}', [TransactionController::class, 'getPayment'])->name('donation.getPayment')->middleware(['auth', 'verified']);
Route::put('donation/payment/{transaction_id}', [TransactionController::class, 'payment'])->name('donation.payment')->middleware(['auth', 'verified']);
Route::get('mydonation', [TransactionController::class, 'mydonation'])->name('mydonation')->middleware(['auth', 'verified']);
Route::get('myprofile', [DonatorController::class, 'myprofile'])->name('myprofile')->middleware(['auth', 'verified']);
Route::get('carousel', [CarouselController::class, 'index'])->name('carousel.index')->middleware(['auth', 'verified']);
Route::post('carousel/store', [CarouselController::class, 'store'])->name('carousel.store')->middleware(['auth', 'verified']);
Route::get('carousel/{id}/edit', [CarouselController::class, 'edit'])->name('carousel.edit')->middleware(['auth', 'verified']);
Route::put('carousel/update/{id}', [CarouselController::class, 'update'])->name('carousel.update')->middleware(['auth', 'verified']);
Route::delete('carousel/delete/{id}', [CarouselController::class, 'destroy'])->name('carousel.destroy')->middleware(['auth', 'verified']);
Route::get('testimonial', [TestimonialController::class, 'index'])->name('testimonial.index')->middleware(['auth', 'verified']);
Route::post('testimonial/store', [TestimonialController::class, 'store'])->name('testimonial.store')->middleware(['auth', 'verified']);
Route::get('testimonial/{id}/edit', [TestimonialController::class, 'edit'])->name('testimonial.edit')->middleware(['auth', 'verified']);
Route::put('testimonial/update/{id}', [TestimonialController::class, 'update'])->name('testimonial.update')->middleware(['auth', 'verified']);
Route::delete('testimonial/delete/{id}', [TestimonialController::class, 'destroy'])->name('testimonial.destroy')->middleware(['auth', 'verified']);
Route::get('carouselSlide', [DashboardController::class, 'carouselSlide'])->name('carousel-slide')->middleware(['auth', 'verified']);


// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

require __DIR__.'/auth.php';
