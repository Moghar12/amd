<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BonSortie extends Model
{
    protected $table = 'bon_sorties'; 

    protected $fillable = [
        'client_id',
        'date',
        'type_document',
        'numero_document',
        'modalite_paiement', // Add the new field to the fillable array
        'tva',
        'prix_total',
        'escpt',

    ];


    public function client()
    {
        return $this->belongsTo(Client::class);
    }


    public function products()
    {
        return $this->belongsToMany(Product::class, 'bon_sortie_product')
                    ->withPivot('quantite', 'prix_unitaire', 'remise', 'prix_total');
    }
}
