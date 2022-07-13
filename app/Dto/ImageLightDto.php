<?php

namespace App\Dto;

use App\Models\Image;

class ImageLightDto extends BaseDto
{
    public string $nameOriginal;
    public string $src;

    public function fromModel(Image $image): self
    {
        return new self([
            'nameOriginal' => $image->getNameOriginal(),
            'src' => $image->getSrc(),
        ]);
    }

    /**
     * @param Image[] $items
     * @return self[]
     */
    public function fromList(array $items): array
    {
        return array_map(fn(Image $item): self => self::fromModel($item), $items);
    }
}
