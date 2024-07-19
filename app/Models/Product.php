<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'price', 'image'];

    protected $casts = [
        'price' => 'float',
    ];

    /**
     * Obtient les catégories de ce produit.
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    /**
     * Scope pour filtrer les produits par catégorie.
     */
    public function scopeInCategory($query, $categoryId)
    {
        return $query->whereHas('categories', function ($q) use ($categoryId) {
            $q->where('categories.id', $categoryId);
        });
    }

    public function getImageUrlAttribute()
    {
        return $this->image_path ? url(Storage::url($this->image_path)) : null;
    }

   
}