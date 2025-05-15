<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductAttribute extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'category_id',
        'attribute_value_id',
        'image',
    ];

    public function product(){
        return $this->belongsTo(Product::class);
    }

    public function category(){
        return $this->belongsTo(category::class);
    }

    public function AttributeValue(){
        return $this->belongsTo(AttributeValue::class);
    }
}
