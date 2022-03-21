<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImagesController;
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
    return view('welcome');
});

Route::get('/imgs/{folder}/{width}x{height}/{image}', [
    'as' => 'image.adaptiveResizeUploads', 
    'uses' => [ImagesController::class, 'adaptiveResizeUploads']
]);
Route::get('/imgc/{width}x{height}/{folder}/{image}', [
    'as' => 'image.ResizeUploadsCached', 
    'uses' =>  [ImagesController::class, 'ResizeUploadsCached']
]);
Route::get('/img/{folder}/{image}', [
    'as' => 'image.ImgUploaded', 
    'uses' => [ImagesController::class, 'showImgUploaded']
]);
Route::get('/download/{folder}/{file}', [
    'as' => 'image.downloadFile', 
    'uses' => [ImagesController::class, 'DownloadUploadFile']
]);