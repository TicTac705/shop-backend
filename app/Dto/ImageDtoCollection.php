<?php

namespace App\Dto;

use App\Models\Image;

class ImageDtoCollection extends BaseDtoCollection
{

    /**
     * @param Image[] $data
     */
    public function __construct(array $data)
    {
        $collection = array_map(fn(Image $item):ImageDto => ImageDto::fromModel($item), $data);

        parent::__construct($collection);
    }
}
