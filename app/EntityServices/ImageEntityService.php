<?php

namespace App\EntityServices;

use App\Services\ImageService;
use Illuminate\Http\JsonResponse;

class ImageEntityService
{
    public function destroy(int $id): JsonResponse
    {
        ImageService::findAndDelete($id);

        return response()->json(['message' => 'Deleted successfully']);
    }
}
