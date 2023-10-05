<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBonEntreesTable extends Migration
{
    public function up()
    {
        Schema::create('bon_entrees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fournisseur_id')->constrained('fournisseurs');
            $table->date('date');
            $table->foreignId('produit_id')->constrained('products');
            $table->integer('quantite');
            $table->decimal('prix_unitaire', 10, 2);
            $table->decimal('remise', 10, 2);
            $table->string('numero_facture');
            $table->enum('type_document', ['facture', 'bl']);
            $table->decimal('prix_total', 10, 2);
            $table->string('code')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bon_entrees');
    }
}
