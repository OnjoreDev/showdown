<?php

use App\Http\Controllers\API\UserAttributeController;
use Illuminate\Support\Facades\Route;

Route::post('/user-attributes/update',[UserAttributeController::class,'update']);