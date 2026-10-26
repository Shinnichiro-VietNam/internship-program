<?php

namespace App\Queries\Book;

use App\Models\Book;
use App\Queries\Book\Filter\FilterBooksByTitle;
use App\Queries\Book\Filter\FilterBooksByAuthor;
use App\Queries\Book\Filter\FilterBooksByMaxPrice;
use App\Queries\Book\Filter\FilterBooksByMinPrice;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

final class ListBooksQuery
{
    public function __construct(
        private FilterBooksByTitle $filterByTitle,
        private FilterBooksByAuthor $filterByAuthor,
        private FilterBooksByMaxPrice $filterByMaxPrice,
        private FilterBooksByMinPrice $filterByMinPrice,
    ) {}

    public function paginate(Request $request): LengthAwarePaginator
    {
        $query = Book::query();

        $query = $this->filterByTitle->apply($query, $request->query('title'));
        $query = $this->filterByAuthor->apply($query, $request->query('author'));
        $minPrice = $request->query('min_price');
        $maxPrice = $request->query('max_price');
        $query = $this->filterByMinPrice->apply(
            $query,
            ($minPrice === null || $minPrice === '') ? null : (float) $minPrice
        );
        $query = $this->filterByMaxPrice->apply(
            $query,
            ($maxPrice === null || $maxPrice === '') ? null : (float) $maxPrice
        );
        $perPage = (int) $request->query('per_page', 8);
        $perPage = min(max($perPage, 1), 50);
        return $query->paginate($perPage);
    }

}