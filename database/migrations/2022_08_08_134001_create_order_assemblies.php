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
        Schema::create('order_assemblies', function (Blueprint $table) {
            $table->id();
            $table->integer("amount");
            $table->foreignId("order_id")->references("id")->on("orders")->cascadeOnDelete();
            $table->float("price");
            $table->foreignId("assembly_id")->references("id")->on("assemblies");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_assemblies');
    }
};
