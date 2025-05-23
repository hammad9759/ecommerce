<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'status'];

    public function values()
    {
        return $this->hasMany(AttributeValue::class);
    }

    public function attributeName()
    {
        return $this->belongsTo(Attribute::class, 'attribute_id');
    }

}
