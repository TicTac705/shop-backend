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
    public ?int $unitMeasureId;
    public ?int $store;
    public ?int $userId;
    public ?bool $isActive;
    public ?array $imagesId;
    public ?array $categories;
    public bool $haveNewImages;

    static function fromRequest(ProductUpdateRequest $request): self
    {
        return new self([
            'name' => $request->get('name'),
            'description' => $request->get('description'),
            'price' => floatval($request->get('price')),
            'unitMeasureId' => intval($request->get('unit_measure_id')),
            'store' => intval($request->get('store')),
            'userId' => Auth::user()->id,
            'isActive' => $request->get('is_active'),
            'imagesId' => $request->get('imagesId'),
            'categories' => $request->get('categories'),
            'haveNewImages' => $request->hasFile('pictures'),
        ]);
    }
}
