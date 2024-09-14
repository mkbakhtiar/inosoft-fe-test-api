<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PipesController extends Controller
{
    private $pipesData;

    public function __construct()
    {
        // Create this variable for getting the data json base
        $this->pipesData = Storage::json('data-inventories.json');
    }

    public function getFilters() {
        // Get initial for filter field
        $filters = [
            'product_type' => [],
            'grade' => [],
            'connection' => [],
            'size' => []
        ];

        // Each data and matches for product_type, grade, connection and size
        foreach ($this->pipesData['data'] as $item) {
            foreach ($filters as $key => $value) {
                if (!in_array($item[$key], $filters[$key])) {
                    $filters[$key][] = $item[$key];
                }
            }
        }

        return response()->json(['filters' => $filters]);
    }
}