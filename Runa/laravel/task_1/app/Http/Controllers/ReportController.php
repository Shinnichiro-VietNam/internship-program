<?php

namespace App\Http\Controllers;

use App\Queries\Report\BookSales;
use App\Queries\Report\BooksNeverSold;
use App\Queries\Report\CustomersByCity;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    //一度も売れたことがない本
    public function booksNeverSold(BooksNeverSold $booksNeverSold)
    {
        return $this->httpOk($booksNeverSold->handle());
    }

    //本ごとの売上集計
    public function bookSales(BookSales $bookSales)
    {
        return $this->httpOk($bookSales->handle());
    }

    //都市ごとの顧客・注文数集計
    public function customersByCity(Request $request, CustomersByCity $customersByCity)
    {
        return $this->httpOk($customersByCity->handle($request->query('city')));
    }
}
