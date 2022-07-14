<?php

namespace App\EntityServices;

use App\Services\ImageService;

class ImageEntityService
{
    public function destroy(int $id): void
    {
        ImageService::findAndDelete($id);
    }
}
