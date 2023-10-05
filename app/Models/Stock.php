<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'quantity',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Méthode pour mettre à jour la quantité du stock
    public static function updateStock($productId, $quantity)
    {
        $stock = self::where('product_id', $productId)->first();

        if ($stock) {
            $stock->quantity += $quantity;
            $stock->save();
        } else {
            self::create([
                'product_id' => $productId,
                'quantity' => $quantity,
            ]);
        }
    }
}
