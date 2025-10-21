<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $primaryKey = 'Product_id';
    protected $fillable = [
        'Product_name',
        'Category_id',
        'Product_price',
        'Product_image',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'Category_id');
    }
}
