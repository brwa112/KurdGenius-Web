<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/*
|--------------------------------------------------------------------------
| Deployment Routes
|--------------------------------------------------------------------------
*/

Route::post('/deploy/migrate', function (Request $request) {
    if ($request->header('X-Deploy-Token') !== config('app.deploy_token')) {
        abort(403, 'Unauthorized');
    }
    
    Artisan::call('migrate', ['--force' => true]);
    
    return response()->json([
        'success' => true,
        'output' => Artisan::output()
    ]);
});
