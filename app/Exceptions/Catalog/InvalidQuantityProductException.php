<?php

namespace App\Exceptions\Catalog;

use App\Helpers\Statuses\HTTPResponseStatuses;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class InvalidQuantityProductException extends Exception
{
    protected $message = 'Invalid quantity product.';

    public function render(Request $request): JsonResponse
    {
        return response()->json(['message' => $this->getMessage()], HTTPResponseStatuses::NOT_FOUND);
    }
}
