<?php

namespace App\Services;

use App\Models\Image;
use App\PivotModels\Catalog\ProductImage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;

class ImageService
{
    /**
     * @param string $path
     * @param UploadedFile[] $images
     * @return array<int>
     */
    public function saveMany(string $path, array $images): array
    {
        $res = [];

        foreach ($images as $file) {
            $res[] = self::save($path, $file);
        }

        return $res;
    }

    public function save(string $path, UploadedFile $image): int
    {
        $userId = Auth::id();

        $fileNameOriginal = $image->getClientOriginalName();
        $fileName = rand() . '_' . $fileNameOriginal;

        $path = $image->storeAs($path, $fileName);

        return Image::create(
            $userId,
            $fileName,
            $fileNameOriginal,
            $image->getSize(),
            $path
        )->saveAndReturnId();
    }

    /**
     * @param array<int> $imageIds
     * @param int $productId
     * @return void
     */
    public function saveManyRelationship(array $imageIds, int $productId): void
    {
        $records = [];
        foreach ($imageIds as $imageId) {
            $records[] = [
                'product_id' => $productId,
                'image_id' => $imageId
            ];
        }

        ProductImage::insert($records);
//        ProductImage::saveMany($records);
    }
}
