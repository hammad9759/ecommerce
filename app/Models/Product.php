<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'image',
        'item_code',
        'keywords',
        'description',
        'category_id',
        'brand_id',
        'tax_id',
        'status',
        'stock_status'
    ];

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function colors(){
        return $this->belongsTo(Color::class);
    }
    public function size(){
        return $this->belongsTo(Size::class);
    }

    

    public function brand(){
        return $this->belongsTo(Brand::class);
    }

    public function tax(){
        return $this->belongsTo(Tax::class);
    }

    public function attributes(){
        return $this->hasMany(ProductAttribute::class);
    }

    public function productAttrs(){
        return $this->hasMany(ProductAttr::class);
    }

}
