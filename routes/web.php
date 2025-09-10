<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectTreeController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return view('login'); // login page
});

Route::get('/register', function() {
    return view('register');
});

Route::get('/project/{id}/tree', [ProjectTreeController::class, 'show'])->name('project.tree');


Route::get('/dashboard', function() {
    return view('dashboard');
});

Route::get('/uploadfile', function() {
    return view('uploadfile');
});

Route::get('/createproject', function() {
    return view('createproject');
});


Route::get('/project/{id}', function ($id) {
    return view('project', ['projectId' => $id]);
});


Route::get('/vote', function() {
    return view('vote');
});