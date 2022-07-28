<?php

namespace App\Services;

use App\Models\Image;
use App\Services\Catalog\ProductService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;

class ImageService
{
    /**
     * @param string $path
     * @param UploadedFile[] $images
     * @return string[]
     */
    public function saveMany(string $path, array $images): array
    {
        $res = [];

        foreach ($images as $file) {
            $res[] = self::save($path, $file);
        }

        return $res;
    }

    public function save(string $path, UploadedFile $image): string
    {
        $path = ltrim($path, " \n\r\t\v\x00\/");
        $path = rtrim($path, " \n\r\t\v\x00\/");

        $userId = Auth::id();

        $fileNameOriginal = $image->getClientOriginalName();
        $fileName = rand() . '_' . $fileNameOriginal;

        $path = $image->storeAs('public/' . $path, $fileName);

        $path = str_replace('public/', '', $path);

        return Image::create(
            $userId,
            $fileName,
            $fileNameOriginal,
            $image->getSize(),
            '/storage/' . $path
        )->saveAndReturnId();
    }

    public function findAndDelete(string $id): void
    {
        $image = Image::query()->findOrFail($id);

        ProductService::deleteImage($id);

        $image->delete();
    }
}
