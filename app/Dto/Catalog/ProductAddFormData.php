<?php

namespace App\Dto\Catalog;

use App\Dto\BaseObjectData;
use App\Http\Requests\Catalog\AdditionProductRequest;

class ProductAddFormData extends BaseObjectData
{
    public string $name;
    public string $description;
    public float $price;
    public string $unitMeasure;
    public int $store;

    /**
     * @var null|array<string>
     */
    public ?array $pictures;

    /**
     * @var array<string>
     */
    public array $categories;

    /**
     * @param AdditionProductRequest $request
     * @param array<string>|null $uploadedImages
     * @return static
     */
    static function fromRequest(AdditionProductRequest $request, ?array $uploadedImages): self
    {
        return new self([
            'name' => $request->get('name'),
            'description' => $request->get('description'),
            'price' => floatval($request->get('price')),
            'unitMeasure' => $request->get('unit_measure'),
            'store' => intval($request->get('store')),
            'pictures' => $uploadedImages,
            'categories' => $request->get('categories'),
        ]);
    }
}
