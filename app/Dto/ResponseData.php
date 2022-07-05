<?php

namespace App\Dto;

use App\Helpers\Statuses\HTTPResponseStatuses;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class ResponseData extends BaseDto implements Responsable
{
    public int $status = HTTPResponseStatuses::OK;

    /**
     * @var BaseDto|BaseDtoCollection
     */
    public $data;


    /**
     * @param $request
     * @return JsonResponse|Response
     */
    public function toResponse($request)
    {
        return response()->json(
            [
                'data' => $this->data->toArray(),
            ],
            $this->status
        );
    }
}
