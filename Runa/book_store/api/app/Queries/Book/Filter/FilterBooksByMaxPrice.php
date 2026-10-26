<?php

namespace App\Queries\Book\Filter;

use Illuminate\Database\Eloquent\Builder;

final class FilterBooksByMaxPrice
{
    public function apply(Builder $query, ?float $maxPrice): Builder
    {
        if ($maxPrice === null || $maxPrice === '') {
            return $query;
        }
        return $query->where('price', '<=', $maxPrice);
    }
}