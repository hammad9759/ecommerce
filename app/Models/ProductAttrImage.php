<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductAttrImage extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'product_attr_id', 'image'];

    public function product(){
        return $this->belongsTo(Product::class);
    }

    public function productAttr(){
        return $this->belongsTo(ProductAttr::class);
    }



}
