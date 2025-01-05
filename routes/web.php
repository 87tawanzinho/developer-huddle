<?php

use App\Http\Controllers\InviteController;
use App\Http\Controllers\ProjectController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

 
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');


    Route::get('/', function () {
        return Inertia::render('LandingPage');
    })->name('landing_page');


    Route::get('/about', function () {
        return Inertia::render('About');
    })->name('about');


    Route::get('/projects', [ProjectController::class,'home'])->name('projects');
    Route::get('/show/{id}', [ProjectController::class,'show'])->name('projects.show');
    Route::post('/createProject', [ProjectController::class,'create'])->name('projects.create');
    Route::delete('/removeProject/{id}', [ProjectController::class,'delete'])->name('projects.delete');
    

    // tasks creation 
    Route::post('/createTask', [ProjectController::class,'createTask'])->name('projects.createTask');
    Route::delete('/deleteTask', [ProjectController::class,'deleteTask'])->name('projects.deleteTask');
    Route::put('/updateTask/{projectId}/{taskId}', [ProjectController::class,'updateTask'])->name('projects.updateTask');
    // invite
    Route::post('/sendInvite', [InviteController::class, 'store'])->name('invite.send');  
    Route::post('/updateInvite', [InviteController::class,'updateInvite'])->name('projects.updateInvite');
    

    Route::get('/prices', function () {
        return Inertia::render('Prices');
    })->name('prices');
});


 