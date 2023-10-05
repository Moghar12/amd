<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('code_produit');
            $table->string('nom');
            $table->integer('quantite');
            $table->unsignedBigInteger('categorie_id');
            $table->decimal('prix_achat_ht', 8, 2);
            $table->decimal('prix_achat_ttc', 8, 2);
            $table->decimal('pph_ttc', 8, 2);
            $table->string('image')->nullable();
            $table->timestamps();

            $table->foreign('categorie_id')->references('id')->on('categories')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
}
