<?php
namespace App\EntityServices\Catalog;

use App\Dto\Catalog\ProductAddFormData;
use App\Helpers\Statuses\HTTPResponseStatuses;
use App\Http\Requests\Catalog\AdditionProductRequest;
use App\Models\Catalog\Product;
use App\Services\ImageService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class CatalogManagementServiceController
{
    /**
     * @param AdditionProductRequest $request
     * @return Application|ResponseFactory|Response
     */
    public function addProduct(AdditionProductRequest $request)
    {
        $userId = Auth::id();

        $uploadedImages = null;

        if ($request->hasFile('pictures')) {
            $uploadedImages = ImageService::upload('catalog_img', $request->file('pictures'));
        }

        if ($uploadedImages !== null && !is_array($uploadedImages)){
            $uploadedImages = [$uploadedImages];
        }

        $productFormData = ProductAddFormData::fromRequest($request, $uploadedImages);

        Product::create(
            $productFormData->name,
            $productFormData->description,
            $productFormData->price,
            $productFormData->unitMeasure,
            $productFormData->store,
            $productFormData->pictures,
            $productFormData->categories,
            $userId
        )->save();

        return response('', HTTPResponseStatuses::OK);
    }
}
