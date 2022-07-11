<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/v1/user', function (Request $request) {
    return $request->user();
});

//Auth
use App\Http\Controllers\AuthController;

Route::post('/v1/login', [AuthController::class, 'login']);
Route::post('/v1/register', [AuthController::class, 'register']);
Route::post('/v1/logout', [AuthController::class, 'logout']);
Route::middleware('auth:sanctum')->get('/v1/test', [AuthController::class, 'test']);

//Food
use App\Http\Controllers\FoodController;

Route::middleware('auth:sanctum')->get('/v1/foods', [FoodController::class, 'index']);

Route::middleware('auth:sanctum')->get('/v1/foods/show_active', [FoodController::class, 'show_active']);

Route::middleware('auth:sanctum')->get('/v1/foods/{id}', [FoodController::class, 'show']);

Route::middleware('auth:sanctum')->post('/v1/foods',[FoodController::class, 'create']);

Route::middleware('auth:sanctum')->post('/v1/foods/update/{id}', [FoodController::class, 'update']);

Route::middleware('auth:sanctum')->post('/v1/foods/delete/{id}', [FoodController::class, 'delete']);

//User
use App\Http\Controllers\UserController;

Route::middleware('auth:sanctum')->get('/v1/users', [UserController::class, 'index']);

Route::middleware('auth:sanctum')->get('/v1/users/show_active', [UserController::class, 'show_active']);

Route::middleware('auth:sanctum')->get('/v1/users/{id}', [UserController::class, 'show']);

Route::middleware('auth:sanctum')->post('/v1/users',[UserController::class, 'create']);

Route::middleware('auth:sanctum')->post('/v1/users/update/{id}', [UserController::class, 'update']);

Route::middleware('auth:sanctum')->post('/v1/users/delete/{id}', [UserController::class, 'delete']);

//Intake
use App\Http\Controllers\IntakeController;

Route::middleware('auth:sanctum')->get('/v1/intakes', [IntakeController::class, 'index']);

Route::middleware('auth:sanctum')->get('/v1/intakes/show_active', [IntakeController::class, 'show_active']);

Route::middleware('auth:sanctum')->get('/v1/intakes/user/{id}', [IntakeController::class, 'show_user']);

Route::middleware('auth:sanctum')->get('/v1/intakes/{id}', [IntakeController::class, 'show']);

Route::middleware('auth:sanctum')->post('/v1/intakes',[IntakeController::class, 'create']);

Route::middleware('auth:sanctum')->post('/v1/intakes/update/{id}', [IntakeController::class, 'update']);

Route::middleware('auth:sanctum')->post('/v1/intakes/delete/{id}', [IntakeController::class, 'delete']);

//User Issues
use App\Http\Controllers\UserIssuesController;

Route::middleware('auth:sanctum')->get('/v1/user_issues', [UserIssuesController::class, 'index']);

Route::middleware('auth:sanctum')->get('/v1/user_issues/show_active', [UserIssuesController::class, 'show_active']);

Route::middleware('auth:sanctum')->get('/v1/user_issues/{id}', [UserIssuesController::class, 'show']);

Route::middleware('auth:sanctum')->post('/v1/user_issues',[UserIssuesController::class, 'create']);

Route::middleware('auth:sanctum')->post('/v1/user_issues/update/{id}', [UserIssuesController::class, 'update']);

Route::middleware('auth:sanctum')->post('/v1/user_issues/delete/{id}', [UserIssuesController::class, 'delete']);

//Food Properties
use App\Http\Controllers\FoodPropertiesController;

Route::middleware('auth:sanctum')->get('/v1/food_properties', [FoodPropertiesController::class, 'index']);

Route::middleware('auth:sanctum')->get('/v1/food_properties/show_active', [FoodPropertiesController::class, 'show_active']);

Route::middleware('auth:sanctum')->get('/v1/food_properties/food/{id}', [FoodPropertiesController::class, 'show_food']);

Route::middleware('auth:sanctum')->get('/v1/food_properties/{id}', [FoodPropertiesController::class, 'show']);

Route::middleware('auth:sanctum')->post('/v1/food_properties',[FoodPropertiesController::class, 'create']);

Route::middleware('auth:sanctum')->post('/v1/food_properties/update/{id}', [FoodPropertiesController::class, 'update']);

Route::middleware('auth:sanctum')->post('/v1/food_properties/delete/{id}', [FoodPropertiesController::class, 'delete']);

//Daily Limit
use App\Http\Controllers\DailyLimitController;

Route::middleware('auth:sanctum')->get('/v1/daily_limit', [DailyLimitController::class, 'index']);

Route::middleware('auth:sanctum')->get('/v1/daily_limit/show_active', [DailyLimitController::class, 'show_active']);

Route::middleware('auth:sanctum')->get('/v1/daily_limit/user/{id}', [DailyLimitController::class, 'show_user']);

Route::middleware('auth:sanctum')->get('/v1/daily_limit/{id}', [DailyLimitController::class, 'show']);

Route::middleware('auth:sanctum')->post('/v1/daily_limit',[DailyLimitController::class, 'create']);

Route::middleware('auth:sanctum')->post('/v1/daily_limit/update/{id}', [DailyLimitController::class, 'update']);

Route::middleware('auth:sanctum')->post('/v1/daily_limit/delete/{id}', [DailyLimitController::class, 'delete']);

//Health Issues
use App\Http\Controllers\HealthIssuesController;

Route::middleware('auth:sanctum')->get('/v1/health_issues', [HealthIssuesController::class, 'index']);

Route::middleware('auth:sanctum')->get('/v1/health_issues/show_active', [HealthIssuesController::class, 'show_active']);

Route::middleware('auth:sanctum')->get('/v1/health_issues/{id}', [HealthIssuesController::class, 'show']);

Route::middleware('auth:sanctum')->post('/v1/health_issues',[HealthIssuesController::class, 'create']);

Route::middleware('auth:sanctum')->post('/v1/health_issues/update/{id}', [HealthIssuesController::class, 'update']);

Route::middleware('auth:sanctum')->post('/v1/health_issues/delete/{id}', [HealthIssuesController::class, 'delete']);

//Role
use App\Http\Controllers\RoleController;

Route::middleware('auth:sanctum')->get('/v1/health_issues', [RoleController::class, 'index']);

Route::middleware('auth:sanctum')->get('/v1/health_issues/show_active', [RoleController::class, 'show_active']);

Route::middleware('auth:sanctum')->get('/v1/health_issues/{id}', [RoleController::class, 'show']);

Route::middleware('auth:sanctum')->post('/v1/health_issues',[RoleController::class, 'create']);

Route::middleware('auth:sanctum')->post('/v1/health_issues/update/{id}', [RoleController::class, 'update']);

Route::middleware('auth:sanctum')->post('/v1/health_issues/delete/{id}', [RoleController::class, 'delete']);