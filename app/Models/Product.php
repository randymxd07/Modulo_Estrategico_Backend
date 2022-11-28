<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'id' => 'integer',
        'product_category_id' => 'integer',
        'price' => 'decimal:2',
        'status' => 'boolean',
    ];

    public function orderProduct()
    {
        return $this->belongsTo(OrderProduct::class);
    }

    public function recipe()
    {
        return $this->belongsTo(Recipe::class);
    }

    public function menusVsProduct()
    {
        return $this->belongsTo(MenusVsProduct::class);
    }

    public function productCategory()
    {
        return $this->belongsTo(ProductCategory::class);
    }

    public function productCategories()
    {
        return $this->hasMany(ProductCategory::class);
    }
}
