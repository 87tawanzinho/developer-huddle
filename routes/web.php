<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\InviteController;
use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Models\Plan;

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

    // tasks creation
    Route::post('/createTask', [ProjectController::class, 'createTask'])->name('projects.createTask');
    Route::delete('/deleteTask', [ProjectController::class, 'deleteTask'])->name('projects.deleteTask');
    Route::put('/updateTask/{projectId}/{taskId}', [ProjectController::class, 'updateTask'])->name('projects.updateTask');
    // invite
    Route::post('/sendInvite', [InviteController::class, 'store'])->name('invite.send');
    Route::post('/updateInvite', [InviteController::class, 'updateInvite'])->name('projects.updateInvite');



    // create comments on tasks

    Route::post('/createComment', [CommentController::class, 'store'])->name('comments.createComment');

    Route::get('/prices', function () {
        $currentPlan = auth()->user()->plan;
        $plans = Plan::all()->except($currentPlan->id);

        return Inertia::render('Prices',
        compact('plans', 'currentPlan'));
    })->name('prices');
});


