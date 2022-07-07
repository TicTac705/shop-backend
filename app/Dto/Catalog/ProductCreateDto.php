<?php

namespace App\Dto\Catalog;

use App\Dto\BaseDto;
use App\Http\Requests\Catalog\AdditionProductRequest;
use Illuminate\Support\Facades\Auth;

class ProductCreateDto extends BaseDto
{
    public string $name;
    public string $description;
    public float $price;
    public int $unitMeasureId;
    public int $store;
    public int $userId;
    public array $categories;

    /**
     * @param AdditionProductRequest $request
     * @return static
     */
    static function fromRequest(AdditionProductRequest $request): self
    {
        return new self([
            'name' => $request->get('name'),
            'description' => $request->get('description'),
            'price' => floatval($request->get('price')),
            'unitMeasureId' => intval($request->get('unit_measure_id')),
            'store' => intval($request->get('store')),
            'userId' => Auth::user()->id,
            'categories' => $request->get('categories'),
        ]);
    }
}
