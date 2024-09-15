<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class PipesController extends Controller
{
    private $pipesData;

    public function __construct()
    {
        $this->pipesData = Storage::json('data-inventories.json');
        // Add debugging to check if data is loaded correctly
        Log::info('Pipes data loaded:', ['count' => count($this->pipesData['data'] ?? [])]);
    }

    public function getFilters(Request $request) {
        $selectedFilters = [
            'product_type' => $request->query('productType'),
            'grade' => $request->query('grade'),
            'connection' => $request->query('connection'),
            'size' => $request->query('size')
        ];

        // Log the selected filters for debugging
        Log::info('Selected filters:', $selectedFilters);

        $filters = [
            'product_type' => [],
            'grade' => [],
            'connection' => [],
            'size' => []
        ];

        $matchCount = 0;
        foreach ($this->pipesData['data'] as $item) {
            $matchesAllFilters = true;

            foreach ($selectedFilters as $key => $value) {
                if ($value && strtolower($item[$key]) !== strtolower($value)) {
                    $matchesAllFilters = false;
                    break;
                }
            }

            if ($matchesAllFilters) {
                $matchCount++;

                foreach ($filters as $key => $value) {
                    // Initialize the filter option count if not already set
                    if (!isset($filters[$key][$item[$key]])) {
                        $filters[$key][$item[$key]] = 0;
                    }

                    // Increment the count for this filter option
                    $filters[$key][$item[$key]]++;
                }
            }
        }

        // Log the match count and resulting filters
        Log::info('Matches found:', ['count' => $matchCount]);
        Log::info('Resulting filters:', $filters);

        // Sort filters by key names (optional) and format to include name and count
        foreach ($filters as &$options) {
            ksort($options); // Sort by key (filter value)
            $options = collect($options)->map(function ($count, $name) {
                return ['name' => (string)$name, 'count' => $count]; // Reformat with name and count
            })->values()->toArray(); // Convert to array
        }

        return response()->json([
            'filters' => $filters,
            'selected' => $selectedFilters,
        ]);
    }


    public function search(Request $request)
    {
        $filters = [
            'product_type' => $request->query('productType'),
            'grade' => $request->query('grade'),
            'connection' => $request->query('connection'),
            'size' => $request->query('size')
        ];

        // Log the search filters
        Log::info('Search filters:', $filters);

        $results = collect($this->pipesData['data'])->filter(function ($item) use ($filters) {
            foreach ($filters as $key => $value) {
                if (!empty($value) && strtolower($item[$key]) != strtolower($value)) {
                    return false;
                }
            }
            return true;
        })->values();

        // Log the number of results
        Log::info('Search results count:', ['count' => $results->count()]);

        return response()->json($results);
    }
}