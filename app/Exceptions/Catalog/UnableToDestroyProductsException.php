<?php

namespace App\Exceptions\Catalog;

use App\Helpers\Statuses\HTTPResponseStatuses;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UnableToDestroyProductsException extends Exception
{
    /**
     * @var string[]
     */
    private array $itemIds;
    public function __construct($message = "", $itemIds = [])
    {
        $this->itemIds = $itemIds;
        parent::__construct($message);
    }

    public function render(Request $request): JsonResponse
    {
        return response()->json(['message' => $this->getMessage(), 'data' => $this->itemIds], HTTPResponseStatuses::NOT_FOUND);
    }

}
