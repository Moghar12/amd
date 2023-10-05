<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BonEntree extends Model
{
    use HasFactory;

    protected $fillable = [
        'fournisseur_id',
        'date',
        'produit_id',
        'quantite',
        'prix_unitaire',
        'remise',
        'numero_facture',
        'type_document',
        'prix_total',
    ];
    protected $table = 'bon_entrees';

    public function fournisseur()
    {
        return $this->belongsTo(Fournisseur::class);
    }

    public function products()
{
    return $this->belongsToMany(Product::class, 'bon_entree_product')
                ->withPivot('quantite', 'prix_unitaire', 'remise', 'prix_total');
}

    

}

