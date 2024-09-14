<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PipesController;

Route::get('/filters', [PipesController::class, 'getFilters']); // route api for get data filters
Route::get('/search', [PipesController::class, 'search']); // route api for call api search with some parameters