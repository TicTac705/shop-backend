<?php

namespace App\Http\Controllers;

use App\EntityServices\ImageEntityService;
use Illuminate\Http\JsonResponse;

class ImageController extends Controller
{
    public function destroy(int $id): JsonResponse
    {
        ImageEntityService::destroy($id);

        return response()->json(['message' => 'Deleted successfully']);
    }
}
