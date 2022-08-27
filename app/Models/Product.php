<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'product_name',
        'product_barcode',
        'price_based_on',
    ];
    
    /**
     * variation
     *
     * @return void
     */
    public function variation() {
        return $this->hasMany(ProductVariation::class);
    }
    
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
