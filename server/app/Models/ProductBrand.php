<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductBrand extends Model
{
    use HasFactory;


    public $timestamps = false;

    protected $table = 'product_brands';
    protected $primaryKey = null;
    public $incrementing = false;
    protected $fillable = ['product_id', 'brand_id'];


    public function product()
    {
        return $this->belongsTo(Product::class);
    }


    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
}
