<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductVariation extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'price',
        'unit',
        'product_id'
    ];

    /**
     * ProductImage
     *
     * @return void
     */
    public function productImage()
    {
        return $this->hasMany(ProductImage::class);
    }

}
