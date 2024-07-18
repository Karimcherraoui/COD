<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'parent_id'];

    /**
     * Obtient la catégorie parente.
     */
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    /**
     * Obtient les catégories enfants.
     */
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    /**
     * Obtient les produits de cette catégorie.
     */
    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

    /**
     * Vérifie si la catégorie est une catégorie racine (sans parent).
     */
    public function isRoot()
    {
        return is_null($this->parent_id);
    }

    /**
     * Obtient toutes les catégories racines.
     */
    public static function roots()
    {
        return static::whereNull('parent_id')->get();
    }

    /**
     * Obtient le chemin complet de la catégorie.
     */
    public function getFullPathAttribute()
    {
        $path = [$this->name];
        $parent = $this->parent;

        while (!is_null($parent)) {
            array_unshift($path, $parent->name);
            $parent = $parent->parent;
        }

        return implode(' > ', $path);
    }
}