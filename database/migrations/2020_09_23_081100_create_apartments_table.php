<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApartmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apartments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users');
            $table->string('title');
            $table->text('description')->nullable();
            $table->integer('rooms');
            $table->integer('beds');
            $table->integer('baths');
            $table->integer('square_meters');
            $table->string('address');
            $table->decimal('lat', 6, 4)->nullable();
            $table->decimal('lon', 6, 4)->nullable();
            $table->decimal('price', 5, 2)->nullable();
            $table->text('image');
            $table->tinyInteger('active')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('apartments');
    }
}
