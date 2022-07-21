<?php

namespace App\Dto\Catalog;

use App\Dto\BaseDto;
use App\Http\Requests\Catalog\ProductCreationRequest;
use Illuminate\Support\Facades\Auth;

class ProductCreateDto extends BaseDto
{
    public bool $isActive;
    public string $name;
    public string $description;
    public float $price;
    public int $unitMeasureId;
    public int $store;
    public int $userId;
    public ?array $imagesId;
    public array $categories;

    static function fromRequest(ProductCreationRequest $request): self
    {
        return new self([
            'isActive' => $request->get('is_active'),
            'name' => $request->get('name'),
            'description' => $request->get('description'),
            'price' => floatval($request->get('price')),
            'unitMeasureId' => intval($request->get('unit_measure_id')),
            'store' => intval($request->get('store')),
            'userId' => Auth::user()->id,
            'imagesId' => $request->get('imagesId'),
            'categories' => $request->get('categories'),
        ]);
    }
}
