<?php

namespace App\EntityServices;

use App\Services\ImageService;

class ImageEntityService
{
    private ImageService $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    public function destroy(int $id): void
    {
        $this->imageService->findAndDelete($id);
    }
}
