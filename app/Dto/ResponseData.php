<?php

namespace App\Dto;

use App\Helpers\Statuses\HTTPResponseStatuses;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;

final class ResponseData extends BaseDto implements Responsable
{
    public int $status = HTTPResponseStatuses::OK;

    public BaseDto $data;

    public function toResponse($request): JsonResponse
    {
        return response()->json(['data' => $this->data->toArray()], $this->status);
    }
}
