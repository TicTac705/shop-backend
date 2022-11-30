<?php

namespace App\EntityServices;

use App\Dto\ImageCreateDto;
use App\Services\Catalog\ProductService;
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
     * @return string[]
     */
    public function store(ImageCreateDto $dto): array
    {
        return $this->imageService->saveMany('catalog_img', $dto->images);
    }

    public function destroy(string $id): void
    {
        $this->imageService->findAndDelete($id);
    }
}
