<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("assembly_components", function (Blueprint $table) {
            $table->dropUnique(["component_id", "location"]);
            $table->unique(["assembly_id", "location"]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("assembly_components", function (Blueprint $table) {
            $table->dropUnique(["assembly_id", "location"]);
            $table->unique(["component_id", "location"]);
        });
    }
};
