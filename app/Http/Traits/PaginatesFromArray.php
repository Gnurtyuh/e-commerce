<?php

namespace App\Http\Traits;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

trait PaginatesFromArray
{
    /**
     * Paginate a plain PHP array using LengthAwarePaginator.
     *
     * @param  array   $items    The full data array from API
     * @param  Request $request  Current request (to resolve page & keep query params)
     * @param  int     $perPage  Items per page (default 10)
     * @return LengthAwarePaginator
     */
    protected function paginateArray(array $items, Request $request, int $perPage = 10): LengthAwarePaginator
    {
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $sliced = array_slice($items, ($currentPage - 1) * $perPage, $perPage);

        return new LengthAwarePaginator(
            $sliced,
            count($items),
            $perPage,
            $currentPage,
            [
                'path'  => $request->url(),
                'query' => $request->query(),
            ]
        );
    }
}
