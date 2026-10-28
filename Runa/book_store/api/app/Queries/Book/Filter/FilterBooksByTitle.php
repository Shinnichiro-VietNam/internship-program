<?php

namespace App\Queries\Book\Filter;

use Illuminate\Database\Eloquent\Builder;

final class FilterBooksByTitle
{
    public function apply(Builder $query, ?string $title): Builder
    {
        if ($title === null || $title === '') {
            return $query;
        }
        return $query->where('title', 'like', '%' . $title . '%');
    }
}