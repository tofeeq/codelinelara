<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('films', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',75)->unique();
            $table->text('description')->nullable();
            $table->date('release_date');
            $table->integer('rating');
            $table->decimal('ticket_price', 5, 2);
            $table->string('country',75);
            $table->text('photo')->nullable();;
            $table->text('slug')->nullable();;
            $table->timestamps();        
        });

        Schema::create('film_genres', function (Blueprint $table) {
            
            $table->increments('id');
            $table->integer('film_id')->unsigned();
            
            $table->foreign('film_id')
                ->references('id')
                ->on('films')
                ->onUpdate('cascade')
                ->onDelete('cascade')
                ;
            
            $table->string('genre',75);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('film_genres');
        Schema::dropIfExists('film_comments');
        Schema::dropIfExists('films');
    }
}
