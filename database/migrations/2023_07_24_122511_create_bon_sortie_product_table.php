<?php

// database/migrations/YYYY_MM_DD_HHMMSS_create_bon_sortie_product_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBonSortieProductTable extends Migration
{
    public function up()
    {
        Schema::create('bon_sortie_product', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bon_sortie_id');
            $table->unsignedBigInteger('product_id');
            $table->integer('quantite');
            $table->decimal('prix_unitaire', 10, 2);
            $table->integer('remise')->default(0);
            $table->decimal('prix_total', 10, 2);
            $table->timestamps();

            // Define foreign keys
            $table->foreign('bon_sortie_id')->references('id')->on('bon_sorties')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('bon_sortie_product');
    }
}
