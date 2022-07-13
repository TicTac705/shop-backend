<?php

namespace App\Http\Controllers;

use App\EntityServices\ImageEntityService;
use App\Helpers\Statuses\HTTPResponseStatuses;
use App\Models\Image;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class ImageController extends Controller
{
    public function destroy(int $id): JsonResponse
    {
        return ImageEntityService::destroy($id);
    }
}
