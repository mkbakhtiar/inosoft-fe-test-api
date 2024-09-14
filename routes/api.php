<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PipesController;

Route::get('/filters', [PipesController::class, 'getFilters']);