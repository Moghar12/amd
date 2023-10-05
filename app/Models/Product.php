<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'purchase_price', 'price_with_taxes','pph_ttc','tva', 'category_id', 'product_code', 'quantity', 'image'];

    // Relation avec la catégorie
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    
    public function bonEntrees()
    {
        return $this->belongsToMany(BonEntree::class, 'bon_entree_product', 'product_id', 'bon_entree_id')
            ->withPivot('quantite', 'prix_unitaire', 'remise', 'prix_total');
    }

    public function bonSorties()
    {
        return $this->belongsToMany(BonSortie::class)->withPivot('quantite', 'prix_unitaire', 'remise', 'prix_total');
    }

}
