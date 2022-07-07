<?php

namespace App\Dto;

use App\Helpers\Statuses\HTTPResponseStatuses;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ResponsePaginationData extends BaseDto implements Responsable
{
    public int $status = HTTPResponseStatuses::OK;
    public LengthAwarePaginator $paginator;
    public BaseDtoCollection $collection;

    /**
     * @param $request
     * @return JsonResponse|Response
     */
    public function toResponse($request)
    {
        return response()->json(
            [
                'data' => $this->collection->toArray(),
                'paginate' => [
                    'links' => $this->paginator->linkCollection(),
                    'hasPages' => $this->paginator->hasPages(),
                    'hasMorePages' => $this->paginator->hasMorePages()
                ]
            ],
            $this->status
        );
    }
}
