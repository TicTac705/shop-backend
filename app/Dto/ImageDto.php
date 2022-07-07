<?php
namespace App\Dto;

use App\Models\Image;

class ImageDto extends BaseDto
{
    public int $id;
    public int $userId;
    public string $name;
    public string $nameOriginal;
    public int $size;
    public string $src;
    public int $updatedAt;
    public int $createdAt;

    public function fromModel(Image $image): self
    {
        return new self([
            'id' => $image->id,
            'name' => $image->name,
            'nameOriginal' => $image->name_original,
            'size' => $image->size,
            'src' => $image->src,
            'userId' => $image->user_id,
            'updatedAt' => $image->updated_at->timestamp,
            'createdAt' => $image->created_at->timestamp,
        ]);
    }
}
