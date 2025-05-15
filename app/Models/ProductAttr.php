<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductAttr extends Model{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'color_id',
        'size_id',
        'sku',
        'mrp',
        'price',
        'qty',
        'length',
        'breadth',
        'height',
        'weight'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function productAttr()
    {
        return $this->hasMany(ProductAttr::class);
    }

    public function color()
    {
        return $this->belongsTo(Color::class);
    }

    public function size()
    {
        return $this->belongsTo(Size::class);
    }

    public function images()
    {
        return $this->hasMany(ProductAttrImage::class);
    }

    public function AttrImages(){
        return $this->hasMany(ProductAttrImage::class, 'product_attr_id', 'id');
    }
}
