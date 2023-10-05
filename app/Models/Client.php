<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = ['nom', 'code', 'ville', 'adresse', 'ICE', 'client_code', 'telephone'];

    public function categoryClient()
    {
        return $this->belongsTo(CategoryClient::class);
    }
    public function bonSorties()
    {
        return $this->hasMany(BonSortie::class);
    }
}

