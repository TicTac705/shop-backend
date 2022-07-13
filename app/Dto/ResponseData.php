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

    /**
     * @param mixed $data
     * @param int $status
     */
    public function __construct($data, int $status = HTTPResponseStatuses::OK)
    {
        $parameters = ['data' => $data, 'status' => $status];
        parent::__construct($parameters);
    }

    public function toResponse($request): JsonResponse
    {
        $result = $this->data;

        if (!is_array($this->data)) {
            $result = $this->data->toArray();
        }

        return response()->json(['data' => $result], $this->status);
    }
}
