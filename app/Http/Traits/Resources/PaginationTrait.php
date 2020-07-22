<?php

namespace App\Http\Traits\Resources;

trait PaginationTrait
{
    function paginateLinks()
    {
        $newResource = Json_decode(json_encode($this->resource)) ?? null;
        $this->pagination = method_exists($this->resource, 'currentPage') ? [
            'current_page' => $this->resource->currentPage(),
            'current_page_url' => $newResource->path . '?page=' . $this->resource->currentPage(),
            'first_page_url' => $newResource->first_page_url,
            'next_page_url' => $newResource->next_page_url,
            'prev_page_url' => $newResource->prev_page_url,
            'last_page_url' => $newResource->last_page_url,
            'total_pages' => $this->resource->lastPage(),
            'total_records' => $newResource->total
        ] : [];
    }
}
