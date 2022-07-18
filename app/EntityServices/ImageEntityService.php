<?php

namespace App\EntityServices;

use App\Dto\ImageCreateDto;
use App\Services\ImageService;

class ImageEntityService
{
    private ImageService $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    /**
     * @param ImageCreateDto $dto
     * @return int[]
     */
    public function store(ImageCreateDto $dto): array
    {
        return $this->imageService->saveMany('catalog_img', $dto->images);
    }

    public function destroy(int $id): void
    {
        $this->imageService->findAndDelete($id);
    }
}
