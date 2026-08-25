<?php

namespace App\Queries\Report;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

final class CustomersByCity
{
    public function handle(?string $city = null): Collection
    {
        return DB::table('customers as c')
            ->leftJoin('orders as o', 'o.customer_id', '=', 'c.customer_id')
            ->select(
                'c.city',
                DB::raw('COUNT(DISTINCT c.customer_id) as customer_count'),
                DB::raw('COUNT(o.order_id) as order_count')
            )
            ->when($city !== null && $city !== '', fn ($q) => $q->where('c.city', $city))
            ->groupBy('c.city')
            ->get();
    }
}
