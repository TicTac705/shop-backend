<?php

namespace App\Dto;

use Illuminate\Pagination\LengthAwarePaginator;

class PaginationDto extends BaseDto
{
    public array $paginate;
    /** @var  \App\Dto\BaseDto[] */
    public array $collection;

    /**
     * @param LengthAwarePaginator $paginator
     * @param BaseDto[] $collection
     * @return static
     */
    public static function fromResultService(LengthAwarePaginator $paginator, array $collection): self
    {
        return new self([
            'paginate' => [
                'lastPage' => $paginator->lastPage(),
                'currentPage' => $paginator->currentPage(),
                'totalElements' => $paginator->total(),
            ],
            'collection' => $collection
        ]);
    }
}
