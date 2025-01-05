<?php

use App\Http\Controllers\InviteController;
use App\Http\Controllers\ProjectController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
        return Inertia::render('LandingPage');
    })->name('landing_page');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');



    Route::get('/about', function () {
        return Inertia::render('About');
    })->name('about');


    Route::apiResource('projects', ProjectController::class);

//    Route::get('/home', [ProjectController::class,'home'])->name('home');
//    Route::get('/show/{id}', [ProjectController::class,'show'])->name('projects.show');
//    Route::post('/createProject', [ProjectController::class,'create'])->name('projects.create');
//    Route::delete('/removeProject/{id}', [ProjectController::class,'delete'])->name('projects.delete');


    // tasks creation
    Route::post('/createTask', [ProjectController::class,'createTask'])->name('projects.createTask');
    Route::delete('/deleteTask', [ProjectController::class,'deleteTask'])->name('projects.deleteTask');
    Route::put('/updateTaskDescription/{projectId}/{taskId}', [ProjectController::class,'updateTaskDescription'])->name('projects.updateTaskDescription');
    // invite
    Route::post('/sendInvite', [InviteController::class, 'store'])->name('invite.send');
    Route::post('/updateInvite', [InviteController::class,'updateInvite'])->name('projects.updateInvite');


    Route::get('/prices', function () {
        return Inertia::render('Prices');
    })->name('prices');
});


