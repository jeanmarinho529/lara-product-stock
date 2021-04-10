<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->index();
            $table->foreignId('category_id')->index();
            $table->string('name')->length(150);
            $table->string('description')->nullable();
            $table->string('slug')->unique();
            $table->decimal('amount', 10, 2)->default(0);
            $table->integer('current_quantity')->length(4)->default(0);
            $table->integer('minimum_quantity')->length(4)->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
