<?php

namespace App\Models;

use Database\Factories\BookFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    /** @use HasFactory<BookFactory> */
    use HasFactory;

    protected $table = 'books';

    protected $primaryKey = 'book_id';

    public $timestamps = false;

    protected $fillable = [
        'title',
        'author',
        'price',
        'stock_qty',
        'published_year',
    ];

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'book_id', 'book_id');
    }
}