<?php

namespace App\Services;

use App\Models\Image;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;

class ImageService
{
    /**
     * @param string $path
     * @param UploadedFile[] $images
     * @return array<string>
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
}
