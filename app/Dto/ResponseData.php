<?php

namespace App\Dto;

use App\Helpers\Statuses\HTTPResponseStatuses;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;

final class ResponseData extends BaseDto implements Responsable
{
    public int $status = HTTPResponseStatuses::OK;

    /**
     * @var mixed
     */
    public $data;

    public function toResponse($request): JsonResponse
    {
        $result = $this->data;

        if (!is_array($this->data)) {
            $result = $this->data->toArray();
        }

        return response()->json(['data' => $result], $this->status);
    }
}
