<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProductFieldsToTrocsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('trocs', function (Blueprint $table) {
            $table->unsignedBigInteger('product_id')->nullable()->after('type');
            $table->unsignedBigInteger('product_id_offered')->nullable()->after('product_id');
            $table->unsignedBigInteger('product_id_wanted')->nullable()->after('product_id_offered');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('trocs', function (Blueprint $table) {
            $table->dropColumn(['product_id', 'product_id_offered', 'product_id_wanted']);
        });
    }
}
