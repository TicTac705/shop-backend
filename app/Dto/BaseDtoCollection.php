<?php

namespace App\Dto;

use Spatie\DataTransferObject\DataTransferObjectCollection;

class BaseDtoCollection extends DataTransferObjectCollection
{
    public function current(): self
    {
        return parent::current();
    }
}
