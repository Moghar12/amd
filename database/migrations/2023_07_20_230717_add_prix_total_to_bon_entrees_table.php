<?php

// database/migrations/xxxx_xx_xx_xxxxxx_add_prix_total_to_bon_entrees_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPrixTotalToBonEntreesTable extends Migration
{
    public function up()
    {
        Schema::table('bon_entrees', function (Blueprint $table) {
            $table->decimal('prix_total', 10, 2)->nullable();
        });
    }

    public function down()
    {
        Schema::table('bon_entrees', function (Blueprint $table) {
            $table->dropColumn('prix_total');
        });
    }
}

