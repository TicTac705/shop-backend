<?php

namespace App\Dto;

use App\Helpers\Statuses\HTTPResponseStatuses;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class ResponseData extends BaseObjectData implements Responsable
{
    public int $status = HTTPResponseStatuses::OK;

    /**
     * @var BaseObjectData|BaseObjectDataCollection
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
