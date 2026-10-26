<?php

namespace App\Queries\Book\Filter;

use Illuminate\Database\Eloquent\Builder;

final class FilterBooksByMinPrice
{
    public function apply(Builder $query, ?float $minPrice): Builder
    {
        if ($minPrice === null || $minPrice === '') {
            return $query;
        }
        return $query->where('price', '>=', $minPrice);
    }
}