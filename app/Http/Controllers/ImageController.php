<?php

namespace App\Http\Controllers;

use App\Dto\ImageCreateDto;
use App\EntityServices\ImageEntityService;
use App\Http\Requests\ImageCreationRequest;
use Illuminate\Http\JsonResponse;

class ImageController extends Controller
{
    private ImageEntityService $imageEntityService;

    public function __construct(ImageEntityService $imageEntityService)
    {
        $this->imageEntityService = $imageEntityService;
    }

    public function store(ImageCreationRequest $request): JsonResponse
    {
        $imageCreateDto = ImageCreateDto::fromRequest($request);

        return response()->json($this->imageEntityService->store($imageCreateDto));
    }

    public function destroy(int $id): JsonResponse
    {
        $this->imageEntityService->destroy($id);

        return response()->json(['message' => 'Deleted successfully']);
    }
}
