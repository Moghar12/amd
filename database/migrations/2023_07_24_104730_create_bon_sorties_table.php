<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBonSortiesTable extends Migration
{
    public function up()
    {
        Schema::create('bon_sorties', function (Blueprint $table) {
            $table->id();
            $table->string('type_document');
            $table->date('date');
            $table->unsignedBigInteger('client_id');
            $table->string('numero_document')->unique();
            $table->decimal('tva', 5, 2);
            $table->decimal('prix_total', 10, 2);
            $table->string('modalite_paiement');
            $table->timestamps();

            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            // Add foreign key constraints and relationships with other tables if needed
        });
    }

    public function down()
    {
        Schema::dropIfExists('bon_sorties');
    }
}
