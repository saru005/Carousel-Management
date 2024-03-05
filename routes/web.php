<?php

use App\Http\Controllers\CarouselController;
use App\Models\Carousel;
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

Route::get('/', function () {
    $carousels = Carousel::where('status',1)->orderBy('id', 'DESC')->get();
    return view('carousels.slider',compact('carousels'));
});
Route::get('carousels',[CarouselController::class,'index'])->name('carousels');
Route::get('carousel/create',[CarouselController::class,'create_page'])->name('carousels-create_page');
Route::post('carousel/create',[CarouselController::class,'create'])->name('carousels-create');
Route::get('carousel/edit/{id}',[CarouselController::class,'edit_page'])->name('edit_page');
Route::post('carousel/edit/{id}',[CarouselController::class,'edit'])->name('carousel-edit');
Route::get('carousel/delete',[CarouselController::class,'delete'])->name('carousel-delete');