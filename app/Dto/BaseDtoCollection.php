<?php

namespace App\Dto;

use Spatie\DataTransferObject\DataTransferObjectCollection;

class BaseDtoCollection extends DataTransferObjectCollection
{
    public function current(): self
    {
        return parent::current();
    }

    public function only(array $keys): self
    {
        $collection = collect($this->collection);

        $this->collection = $collection->map(
            fn($item) => collect(is_array($item) ? $item : $item->toArray())->only($keys)->all()
        )->toArray();

        return $this;
    }
}
