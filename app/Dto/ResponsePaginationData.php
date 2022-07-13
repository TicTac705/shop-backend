<?php

namespace App\Dto;

use App\Helpers\Statuses\HTTPResponseStatuses;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;
use Symfony\Component\HttpFoundation\Response;

class ResponsePaginationData extends BaseDto implements Responsable
{
    public int $status = HTTPResponseStatuses::OK;
    public LengthAwarePaginator $paginator;

    public array $collection;

    /**
     * @param $request
     * @return JsonResponse|Response
     */
    public function toResponse($request)
    {
        return response()->json(
            [
                'data' => $this->collection,
                'paginate' => [
                    'lastPage' => $this->paginator->lastPage(),
                    'currentPage' => $this->paginator->currentPage(),
                    'totalElements' => $this->paginator->total(),
                ]
            ],
            $this->status
        );
    }
}
