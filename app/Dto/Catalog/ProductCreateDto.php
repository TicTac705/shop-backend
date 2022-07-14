<?php

namespace App\Dto\Catalog;

use App\Dto\BaseDto;
use App\Http\Requests\Catalog\ProductCreationRequest;
use Illuminate\Support\Facades\Auth;

class ProductCreateDto extends BaseDto
{
    public string $name;
    public string $description;
    public float $price;
    public int $unitMeasureId;
    public int $store;
    public int $userId;
    /** @var \Illuminate\Http\UploadedFile[]|null */
    public ?array $pictures;
    public array $categories;

    static function fromRequest(ProductCreationRequest $request): self
    {
        return new self([
            'name' => $request->get('name'),
            'description' => $request->get('description'),
            'price' => floatval($request->get('price')),
            'unitMeasureId' => intval($request->get('unit_measure_id')),
            'store' => intval($request->get('store')),
            'userId' => Auth::user()->id,
            'pictures' => $request->file('pictures'),
            'categories' => $request->get('categories'),
        ]);
    }
}
