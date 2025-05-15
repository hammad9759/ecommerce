<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'parent_id', 'image', 'status'];

    // Recursive relationship for nested categories
    public function parent() {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function ancestors()
    {
        $ancestors = collect([]);

        $parent = $this->parent;

        while ($parent) {
            $ancestors->prepend($parent); // Add parent to the beginning of the collection
            $parent = $parent->parent;   // Move up to the next parent
        }

        return $ancestors;
    }

    public function children() {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function attribute(){
        return $this->belongsToOne(Attribute::class, 'category_attributes');
    }
}
