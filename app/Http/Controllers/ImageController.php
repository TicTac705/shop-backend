<?php

namespace App\Http\Controllers;

use App\EntityServices\ImageEntityService;
use Illuminate\Http\JsonResponse;

class ImageController extends Controller
{
    private ImageEntityService $imageEntityService;

    public function __construct(ImageEntityService $imageEntityService)
    {
        $this->imageEntityService = $imageEntityService;
    }

    public function destroy(int $id): JsonResponse
    {
        $this->imageEntityService->destroy($id);

        return response()->json(['message' => 'Deleted successfully']);
    }
}
