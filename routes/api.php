<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MockDataController;

Route::get('/filters', [MockDataController::class, 'getFilters']);