<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\FeedController;
use App\Http\Controllers\InviteController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use Inertia\Inertia;
use App\Models\Plan;

Route::get("/", function () {
    return Inertia::render("LandingPage");
})->name("landing_page");

Route::middleware([
    "auth:sanctum",
    config("jetstream.auth_session"),
    "verified",
])->group(function () {
    Route::get("/about", function () {
        return Inertia::render("About");
    })->name("about");

    Route::apiResource("projects", ProjectController::class);

    // tasks creation
    Route::post("/createTask", [ProjectController::class, "createTask"])->name(
        "projects.createTask"
    );
    Route::delete("/deleteTask", [
        ProjectController::class,
        "deleteTask",
    ])->name("projects.deleteTask");
    Route::put("/updateTask/{projectId}/{taskId}", [
        ProjectController::class,
        "updateTask",
    ])->name("projects.updateTask");
    // invite
    Route::post("/sendInvite", [InviteController::class, "store"])->name(
        "invite.send"
    );
    Route::post("/updateInvite", [
        InviteController::class,
        "updateInvite",
    ])->name("projects.updateInvite");

    // comments
    Route::post("/createComment", [CommentController::class, "store"])->name(
        "comments.createComment"
    );
    Route::post("/likeComment", [CommentController::class, "liked"])->name(
        "comments.liked"
    );

    // feed
    Route::get("/feed", [FeedController::class, "index"])->name("feed");

    // notices
    Route::get("/updates", function () {
        return Inertia::render("Updates");
    })->name("updates");

    Route::get("/prices", function () {
        $currentPlan = auth()->user()->plan;
        $plans = Plan::all()->except($currentPlan->id);

        return Inertia::render("Prices", compact("plans", "currentPlan"));
    })->name("prices");
});

Route::get("/payment", [PaymentController::class, "store"])->name("payment");

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

Route::post("/create-customer", function (Request $request) {
    $response = Http::withHeaders([
        "Content-Type" => "application/json",
        "access_token" => env("ASAAS_ACCESS_TOKEN"), // Pegue o token do arquivo .env
    ])->post("https://sandbox.asaas.com/api/v3/customers", [
        "name" => $request->input("name"),
        "cpfCnpj" => $request->input("cpfCnpj"),
    ]);

    if ($response->failed()) {
        return response()->json(
            [
                "error" => "Erro ao criar cliente no Asaas",
                "details" => $response->json(),
            ],
            $response->status()
        );
    }

    $user = User::find(Auth::id());
    if ($user) {
        $user->update([
            "customerId" => $response->json()["id"],
        ]);
        $user->save();
    }

    return $response->json()["id"];
})->name("create-customer");
