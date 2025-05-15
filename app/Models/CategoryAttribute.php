<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryAttribute extends Model
{
    use HasFactory;

    protected $table = 'category_attributes';

    protected $fillable = [
        'category_id',
        'attribute_id',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // public function attribute(){
    //     return $this->hasOne(Attribute::class,'id','attribute_id');
    // }
    
    public function attribute(){
        return $this->hasMany(Attribute::class,'id','attribute_id')->with('values');
    }

}
