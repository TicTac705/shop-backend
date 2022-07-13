<?php
namespace App\Dto;

use App\Dto\User\UserLightDto;
use App\Models\Image;

class ImageDto extends BaseDto
{
    public int $id;
    public UserLightDto $creator;
    public string $name;
    public string $nameOriginal;
    public int $size;
    public string $src;
    public ?int $updatedAt;
    public ?int $createdAt;

    public function fromModel(Image $image): self
    {
        return new self([
            'id' => $image->getId(),
            'name' => $image->getName(),
            'nameOriginal' => $image->getNameOriginal(),
            'size' => $image->getSize(),
            'src' => $image->getSrc(),
            'creator' => UserLightDto::fromModel($image->user()->getResults()),
            'updatedAt' => $image->getUpdatedAtTimestamp(),
            'createdAt' => $image->getCreatedAtTimestamp(),
        ]);
    }
}
