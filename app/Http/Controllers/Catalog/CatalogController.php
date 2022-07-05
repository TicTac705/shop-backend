<?php

namespace App\Http\Controllers\Catalog;

use App\Http\Controllers\Controller;
use App\Models\Catalog\Product;
use Illuminate\Http\JsonResponse;

class CatalogController extends Controller
{
    public function index()
    {
        return response()->json([
            'products' => Product::paginate(10)
        ]);
    }
}
