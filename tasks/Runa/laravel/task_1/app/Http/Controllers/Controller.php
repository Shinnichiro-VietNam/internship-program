<?php

namespace App\Http\Controllers;

use App\Traits\HandleResponse;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

abstract class Controller
{
    use AuthorizesRequests;
    use HandleResponse;
}
