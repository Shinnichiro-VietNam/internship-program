<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = ['title', 'author', 'price', 'stock_qty', 'published_year'];
}
