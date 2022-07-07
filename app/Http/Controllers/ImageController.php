<?php

namespace App\Http\Controllers;

use App\Helpers\Statuses\HTTPResponseStatuses;
use App\Models\Image;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    public function destroy(int $id)
    {
        try {
            $image = Image::findOrFail($id);
        } catch (ModelNotFoundException $exception) {
            return response()->json(['message' => 'Invalid Request'], HTTPResponseStatuses::NOT_FOUND);
        }

        $image->delete();

        return response()->json(['message' => 'Deleted successfully']);
    }
}
