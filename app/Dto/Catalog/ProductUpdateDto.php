<?php

namespace App\Dto\Catalog;

use App\Dto\BaseDto;
use App\Http\Requests\Catalog\ProductUpdateRequest;
use Illuminate\Support\Facades\Auth;

class ProductUpdateDto extends BaseDto
{
    public ?string $name;
    public ?string $description;
    public ?float $price;
    public ?string $unitMeasureId;
    public ?int $store;
    public ?string $userId;
    public ?bool $isActive;
    public ?array $imagesId;
    public array $categories;

    static function fromRequest(ProductUpdateRequest $request): self
    {
        return new self([
            'name' => $request->get('name'),
            'description' => $request->get('description'),
            'price' => floatval($request->get('price')),
            'unitMeasureId' => $request->get('unit_measure_id'),
            'store' => intval($request->get('store')),
            'userId' => Auth::user()->id,
            'isActive' => $request->get('is_active'),
            'imagesId' => $request->get('imagesId'),
            'categories' => $request->get('categories')
        ]);
    }
}
