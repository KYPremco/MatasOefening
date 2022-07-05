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
        Schema::create('assembly_components', function (Blueprint $table) {
            $table->id();
            $table->foreignId("assembly_id")->references("id")->on("assemblies")->cascadeOnDelete();
            $table->foreignId("component_id")->references("id")->on("components")->cascadeOnDelete();
            $table->string("location", 10);

            $table->unique(["component_id", "location"]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('assembly_components');
    }
};
