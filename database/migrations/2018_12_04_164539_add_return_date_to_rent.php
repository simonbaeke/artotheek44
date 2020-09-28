<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class AddReturnDateToRent extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rents', function ($table) {
            $table->date('returned_at')->default(null)->nullable();;
        });

        Schema::table('rents', function ($table) {
            $table->dropColumn('returned');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rents', function ($table) {
            $table->dropColumn('returned_at');
        });
    }
}
